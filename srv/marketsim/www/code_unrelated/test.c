/*
##########################################################
## COP 4520 U01 - Intro to Parallel Computing - Spring 2015
##
## Programmer: Javier Andrial - 3578336
## Prof. Jason Liu
## 
## Assignment: Group Project - MPI Compression program
##
## Due Date: 04/28/2015 by 11:55pm
##
## We Certify that this program code has been written by us
## and no part of it has been taken from any sources.
##########################################################
*/



#include "mpi.h"
#include <stdio.h>
#include <stdlib.h>
#include <sys/stat.h>
#include <string.h>


////////////////////////////////////////
//#define Presentation // uncomment this to receive printf outputs for each function 
#define int_huff     // uncomment this to not store the huffman code as a char*. this will store the code as a long
//#define canonical_GPU_encoding    // uncomment this to re-code the Huffman code into Canonical Huffman Code. this is required for GPU parallel decompression
		    		  // leave commented out for debugging huffcode written to file.
/////////////////////////////////////////
#define BUFSIZE 500


struct Node* makeNode(unsigned short i);
struct Node* makeNode2(unsigned short i, int fr);
void sendReceive(struct Node **recvbuf, int id, int decrement,int sizeof_set,int tag); // helper func for collectAll - does the sending/receiving
void collectAll(); // sends nodes to other processors
int mergeSort(struct Node *input[], int size,int boolean);
void merge(struct Node *input[], int left, int right, struct Node *temp[], int selector); //mergeSort
void compression_char(MPI_File fpsrc, MPI_File fpdest, long fileLength); // comresses code in characters to be able to see it (will be 8x bigger)
void compression_int(MPI_File fpsrc, MPI_File *fpdest, long fileLength); // compresses in bits. (~30-40% smaller file size)
void serialize(MPI_File fpnode, struct Node *array[]); //saves nodes ids and frequencies to file
void serialize_canonical(MPI_File fpnode);
void canonical_encoding(struct Node * cancalArray[]); // encodes Canonical's huffman code. required for GPU parallel decompression

struct Node
{
   	unsigned short Node_id;	//byte value of a byte from file
	int frequency;		//occurance of node in file
	unsigned long huffman_code_int; //stores huff code
	short huffCodeCount; //length of huff code
	struct Node *left;
	struct Node *right; 
	
	char *huffman_code; //stores huff code
};

int MPI_size;
int MPI_id;
int setSize;
int nodeCount = 0;
int arraySize;
MPI_Status status;
struct Node *arraylist[256];



void lookUpAndAdd(unsigned short id)
{
	if(!arraylist[id])
	{
		arraylist[id] = makeNode(id);
		nodeCount++;
	}
	else
		if(arraylist[id]->Node_id == id)
			arraylist[id]->frequency++;
}


void readFromFile(MPI_File fpsrc, long fileLength)
{
	int buffSize = BUFSIZE;
	char *buf = (char*)malloc(sizeof(char)*buffSize);	
	long position = setSize*MPI_id;
	long endOfSet = (setSize*MPI_id)+setSize;
	short i;
	int a;

	if(!(MPI_id - (MPI_size-1)))
		setSize = fileLength - position;
	int numberOfBytes = setSize;

	arraySize = 256;

	for(a=0;a<arraySize;a++)
		arraylist[a] = NULL;

	#ifdef Presentation
	if(!MPI_id)
		printf("File Length = %lu\n",fileLength);

	printf("MPI_id %d Number of Bytes = %d, buffSize = %d\n",MPI_id,numberOfBytes,buffSize);
	MPI_Barrier( MPI_COMM_WORLD );
	#endif	

	while((numberOfBytes - buffSize) > 0)
	{
		MPI_File_read_at(fpsrc, position, buf, buffSize, MPI_CHAR, &status );

		for(a=0; a < buffSize; a++) 
		{
			i = 255 & buf[a];
			lookUpAndAdd(i);
		}
		numberOfBytes = numberOfBytes - buffSize;
		position += buffSize;
	}

	if(numberOfBytes <  buffSize && numberOfBytes > 0)
	{
		buffSize = buffSize - (buffSize - numberOfBytes);
		MPI_File_read_at(fpsrc, position, buf, buffSize, MPI_CHAR, &status );

		for(a=0; a < buffSize; a++) 
		{
			i = 255 & buf[a];
			lookUpAndAdd(i);
		}
	}
	free(buf);
}


struct Node* makeNode(unsigned short i)
{
	return makeNode2(i,1);
}
struct Node* makeNode2(unsigned short i, int fr)
{
	struct Node *pointer;
	pointer = (struct Node*) malloc(sizeof(struct Node));
	pointer->Node_id = i;
	pointer->frequency = fr;
	//pointer->huffman_code;
	pointer->left=NULL;
	pointer->right=NULL;

	return pointer;
}

struct Node *makeHuffNode(int fr,struct Node *left,struct Node *right)
{
	struct Node *pointer = makeNode2(0,fr);
	pointer->left=left;
	pointer->right=right;
	return pointer;
}


void printArrayList()
{
	struct Node *pointer;
	int item = 0;
	int a = 0;
	int iterator = nodeCount;

	if(MPI_id)
		MPI_Recv(&a, 1, MPI_INT, MPI_id-1, 0, MPI_COMM_WORLD, &status);

	printf(" \n\t=== MPI_id = %d ===\n",MPI_id);
	
	while(iterator)
	{
		pointer = arraylist[a];
		a++;

		if(pointer)
		{
			item++;
			if(pointer->Node_id == 10) // prints '\n' instead of having an endline space in the output
				printf("%d. char = \\n, node_id = %d, frequency = %d, \n", item, pointer->Node_id, pointer->frequency);
			else
				printf("%d. char = %c, node_id = %d, frequency = %d, \n", item, pointer->Node_id, pointer->Node_id, pointer->frequency);
			iterator--;
		}
	}
	a=0;
	if(MPI_id != MPI_size-1)
		MPI_Send(&a, 1, MPI_INT, MPI_id+1, 0, MPI_COMM_WORLD);

}

void printArrayList2(struct Node * array[])
{
	struct Node *pointer;
	int item = 0;
	int a = 0;
	int iterator = nodeCount;

	printf("\n\t=== MPI_id = %d ===\n",MPI_id);
	printf("\t=== Sorted Array ===\n");
	/*
	while(iterator)
	{
		pointer = array[a];
		a++;

		if(pointer)
		{
			item++;
			if(pointer->Node_id == 10)
				printf("%d. char = \\n, node_id = %d, frequency = %d, \n", item, pointer->Node_id, pointer->frequency);
			else
				printf("%d. char = %c, node_id = %d, frequency = %d, \n", item, pointer->Node_id, pointer->Node_id, pointer->frequency);
			iterator--;
		}
	}*/

	for(a = 0; a< nodeCount;a++)
	{
		pointer = array[a];
		if(pointer->Node_id == 10)
			printf("%d. char = \\n, node_id = %d, frequency = %d, \n", a+1, pointer->Node_id, pointer->frequency);
		else
			printf("%d. char = %c, node_id = %d, frequency = %d, \n", a+1, pointer->Node_id, pointer->Node_id, pointer->frequency);
	}
}

// used for printing the actions when creating the Huffman tree
// this is print wether 
void printNode(struct Node *left,struct Node *right,struct Node* parent,int i)
{
	if(MPI_id)
		return;
	else if(!i) // parent - parent
	{
		printf("p&p left *is %d, right *is %d, parent is %d\n",left->frequency,right->frequency,parent->frequency);
	}
	else if(i == 1)//node - parent
		printf("n&p left node is %d, right *is %d, parent is %d\n",left->frequency,right->frequency,parent->frequency); // parent - node
	else if (i==2)
		printf("p&n left  *is %d, right node is %d, parent is %d\n",left->frequency,right->frequency,parent->frequency);
	else // node - node
		printf("n&n left  node is %d, right node is %d, parent is %d\n",left->frequency,right->frequency,parent->frequency);
}	


//Creates Huffman tree. creates parent Nodes and has their left and right point to other nodes
void makeHuffmanTree(struct Node *nodeArray[], struct Node *huffArray[])
{
	int i=0,a=2,b=1;

	//creates first parent node
	huffArray[0] = makeHuffNode((nodeArray[0]->frequency+nodeArray[1]->frequency),nodeArray[0],nodeArray[1]);

	#ifdef Presentation
		if(!MPI_id)
		printf("\n\n\t= Creating Huffman Tree=\n\t= Node Placement=\n\n");
		printNode(nodeArray[0],nodeArray[1],huffArray[0],3);
	#endif

	while(a<nodeCount-1)
	{
		if(huffArray[i]->frequency <= nodeArray[a]->frequency)
		{
			if((i+1 < b) &&(huffArray[i+1]->frequency <= nodeArray[a]->frequency))
			{
				huffArray[b] = makeHuffNode((huffArray[i]->frequency+huffArray[i+1]->frequency),huffArray[i],huffArray[i+1]);//parent on parent
					
					#ifdef Presentation
					printNode(huffArray[i],huffArray[i+1],huffArray[b],0);
					#endif
				i = i+2;
				b++;		
			}
			else
			{
				huffArray[b] = makeHuffNode((nodeArray[a]->frequency+huffArray[i]->frequency),nodeArray[a],huffArray[i]); //node on parent
					#ifdef Presentation
					printNode(nodeArray[a],huffArray[i],huffArray[b],1);
					#endif
				a++;
				i++;
				b++;		
			}		
		}
		else if(huffArray[i]->frequency <= nodeArray[a+1]->frequency)
		{
			huffArray[b] = makeHuffNode((nodeArray[a]->frequency+huffArray[i]->frequency),nodeArray[a],huffArray[i]);//node on parent
				
				#ifdef Presentation
				printNode(nodeArray[a],huffArray[i],huffArray[b],1);
				#endif
			a++;
			i++;
			b++;				
		}
		else
		{
			huffArray[b] = makeHuffNode((nodeArray[a]->frequency+nodeArray[a+1]->frequency),nodeArray[a],nodeArray[a+1]);//node on node

				#ifdef Presentation
				printNode(nodeArray[a],nodeArray[a+1],huffArray[b],3);
				#endif
			a = a + 2;
			b++;						
		}
	}


	if(a!=nodeCount)
		while(b<nodeCount-1)
		{
			if(nodeArray[a]->frequency <= huffArray[i]->frequency)
			{
				huffArray[b] = makeHuffNode((nodeArray[a]->frequency+huffArray[i]->frequency),nodeArray[a],huffArray[i]);//node on parent

					#ifdef Presentation
					printNode(nodeArray[a],huffArray[i],huffArray[b],1);
					#endif
				a++;
				i++;
				b++;
				break;
			}
			else if((i+1 < b) && (huffArray[i+1]->frequency <= nodeArray[a]->frequency) )
			{
				huffArray[b] = makeHuffNode((huffArray[i]->frequency+huffArray[i+1]->frequency),huffArray[i],huffArray[i+1]);//parent on parent

					#ifdef Presentation
					printNode(huffArray[i],huffArray[i+1],huffArray[b],0);
					#endif
				i = i+2;
				b++;
			}
			else
			{
				huffArray[b] = makeHuffNode((nodeArray[a]->frequency+huffArray[i]->frequency),nodeArray[a],huffArray[i]);//node on parent

					#ifdef Presentation
					printNode(nodeArray[a],huffArray[i],huffArray[b],1);
					#endif
				a++;
				i++;
				b++;
				break;
			}
		}

	while(b<nodeCount-1)
	{
		huffArray[b] = makeHuffNode((huffArray[i]->frequency+huffArray[i+1]->frequency),huffArray[i],huffArray[i+1]);//parent on parent

				#ifdef Presentation
				printNode(huffArray[i],huffArray[i+1],huffArray[b],0);
				#endif
		i = i+2;
		b++;	
	}
}



void printNode_encodeHuffman_char(struct Node *pointer)
{
	if(pointer->Node_id == 10)
		printf("char = \\n, node_id = %d, frequency = %d, huffman_code = %s, count =%d\n",
					pointer->Node_id, pointer->frequency,pointer->huffman_code, pointer->huffCodeCount);
	else
		printf("char = %c, node_id = %d, frequency = %d, huffman_code = %s, count =%d\n", 
					pointer->Node_id, pointer->Node_id, pointer->frequency,pointer->huffman_code, pointer->huffCodeCount);
}

void printNode_encodeHuffman_int(struct Node *pointer)
{
	if(pointer->Node_id == 10)
		printf("char = \\n, node_id = %d, frequency = %d, huffman_code = %lu, count =%d\n",  
					pointer->Node_id, pointer->frequency,pointer->huffman_code_int,pointer->huffCodeCount);
	else
		printf("char = %c, node_id = %d, frequency = %d, huffman_code = %lu, count =%d\n", 
					pointer->Node_id, pointer->Node_id, pointer->frequency,pointer->huffman_code_int,pointer->huffCodeCount);
}

void encodeHuffman_char(struct Node *pointer,char *code,int i)
{
	char c[i+1];
	int a = 0;
	
	for(;a<i;a++)
		c[a] = code[a];
	

	if(pointer->left)
	{
		c[i-1]='0';
		c[i] = '\0';
		encodeHuffman_char(pointer->left,c,i+1);
	}
	if(pointer->right)
	{
		c[i-1] = '1';
		c[i] = '\0';
		encodeHuffman_char(pointer->right,c,i+1);
	}
	if(!pointer->left && !pointer->right)
	{
		pointer->huffman_code = (char*)malloc(sizeof(char)*(i+1));

		pointer->huffCodeCount = i-1;
		for(a=0;a<i;a++)
			pointer->huffman_code[a] = c[a];

		#ifdef Presentation
		if(!MPI_id)
			printNode_encodeHuffman_char(pointer);
		#endif	
	}

	return;
}


void encodeHuffman_int(struct Node *pointer,unsigned long i,int count)
{
	if(pointer->left)
	{
		i = i+i;
		encodeHuffman_int(pointer->left,i,count+1);
	}
	if(pointer->right)
	{
		i = i+1;
		encodeHuffman_int(pointer->right,i,count+1);
	}
	if(!pointer->left && !pointer->right)
	{
		pointer->huffman_code_int = i;
		pointer->huffCodeCount = count;

		#ifdef Presentation
		if(!MPI_id)
			printNode_encodeHuffman_int(pointer);
		#endif
	}	
	return;
}


void encode_Huffman(struct Node * huff_tree_root)
{
	#ifdef Presentation
	MPI_Barrier( MPI_COMM_WORLD );
	if(!MPI_id)
		printf("\n\t= Encoding Huffman Code =\n\n");
	#endif

	#ifdef int_huff
		encodeHuffman_int(huff_tree_root, 0,0);
	#else
		char c[1];
		c[0] = '\0';
		encodeHuffman_char(huff_tree_root, c, 1);
	#endif
}



void sendReceive(struct Node *buf[], int id, int decrement,int sizeof_set,int tag)
{	
	int i=0;
	int a=0;
	int size = sizeof_set+1;
	int size_recv;

	short node_id_array[size];
	int frequency_array[size];	



	MPI_Send(&size, 1, MPI_INT, id+decrement, tag +3, MPI_COMM_WORLD);


	for(; a < size; a++)
	{	
		node_id_array[a] = 0;
		frequency_array[a] = 0;
	}


	MPI_Recv(&size_recv, 1, MPI_INT, MPI_ANY_SOURCE, tag+3, MPI_COMM_WORLD, &status);


	short recv_node_id[size_recv];
	int recv_frequency[size_recv];

	for(a=0;a<size_recv;a++)
	{
		recv_node_id[a] = 0;
		recv_frequency[a] = 0;
	}

	
	for(a=0;a<sizeof_set;i++)
	{
		if(buf[i])
		{
			node_id_array[a] = buf[i]->Node_id;
			frequency_array[a] = buf[i]->frequency;
			a++;
		}
	}
	

	MPI_Send(node_id_array, size, MPI_SHORT, id+decrement, tag +1, MPI_COMM_WORLD);
	MPI_Send(frequency_array, size, MPI_INT, id+decrement, tag +2, MPI_COMM_WORLD);

	MPI_Recv(recv_node_id, size_recv, MPI_SHORT, id+decrement, tag +1, MPI_COMM_WORLD, &status);
	MPI_Recv(recv_frequency, size_recv, MPI_INT, id+decrement, tag+2, MPI_COMM_WORLD, &status);

	i=0;
	while(recv_frequency[i])
	{
		if(!buf[recv_node_id[i]])
		{

			buf[(recv_node_id[i])] = makeNode2(recv_node_id[i],recv_frequency[i]);
			nodeCount++;
		}
		else
		{
			buf[recv_node_id[i]]->frequency += recv_frequency[i];	
		}
		setSize += recv_frequency[i];
		i++;
	}
}


void collectAll()
{
	int id = MPI_id;
	int tag = 0;
	int half_size = MPI_size/2;
	int decrement = half_size;

	while(decrement)
	{		
		if(id < half_size)
		{
			sendReceive(arraylist,id,decrement, nodeCount,tag);

			half_size -= decrement/2;
		}
		else
		{
			sendReceive(arraylist,id,-decrement, nodeCount,tag);
			half_size += decrement/2;
		}
		tag += 4;
		decrement = decrement/2;
	}
}

long file_length(char *f)
{
    struct stat st;
    stat(f, &st);
    return st.st_size;
}

char* concat(char *s1, char *s2)
{
    char *result = malloc(strlen(s1)+strlen(s2)+1);
    strcpy(result, s1);
    strcat(result, s2);
    return result;
}

int get_file(int argc, char *argv[], MPI_File *fpsrc, MPI_File *fpdest, MPI_File *fpnode)
{
	char *file_name = concat(argv[2],".huff");
	char *fileNode_name = concat(argv[2],".node");

	if(argc != 3) 
	{
		fprintf(stderr, "Usage: %s offset SRCFILE DSTFILE\n", argv[0]);
		return 1;
	}

    	if (MPI_File_open( MPI_COMM_WORLD, argv[1], MPI_MODE_RDONLY, MPI_INFO_NULL, fpsrc)) 
	{
		if(!MPI_id)
			fprintf(stderr, "ERROR: can't open source file to read: %s\n", argv[1]);
				
		fflush(stdout);

		MPI_File_close( fpsrc );
		return 2;
   	}

 	if (MPI_File_open( MPI_COMM_WORLD, file_name, MPI_MODE_WRONLY | MPI_MODE_CREATE, MPI_INFO_NULL, fpdest)) 
	{
		if(!MPI_id)
			fprintf(stderr, "ERROR: can't open write file to write to: %s\n", argv[2]);
		fflush(stdout);

		MPI_File_close( fpsrc );
		MPI_File_close( fpdest );
		return 3;
   	}
	if (MPI_File_open(MPI_COMM_WORLD, fileNode_name, MPI_MODE_WRONLY | MPI_MODE_CREATE, MPI_INFO_NULL, fpnode)) 
	{
		if(!MPI_id)
			fprintf(stderr, "ERROR: Unable to write Nodes to file:: %s\n", argv[2]);
		fflush(stdout);

		MPI_File_close( fpsrc );
		MPI_File_close( fpdest );
		MPI_File_close( fpnode );
		return 4;
	}

	free(file_name);
	free(fileNode_name);
	return 0;
}

int init(int argc, char *argv[], MPI_File *fpsrc, MPI_File *fpdest,MPI_File *fpnode)
{	
	long fileLength;
	
	
	if(get_file(argc,argv,fpsrc,fpdest,fpnode))
		return 1;
	

	fileLength = file_length(argv[1]);
	setSize = (fileLength/MPI_size);

	readFromFile(*fpsrc,  fileLength);


	#ifdef Presentation
	printArrayList();
	MPI_Barrier( MPI_COMM_WORLD );
	if(!MPI_id)
		printf("\n\t= Starting collectAll =\n");
	#endif

	if(MPI_size > 1)
		collectAll();

	#ifdef Presentation
	if(!MPI_id)
		printf("\n\t= finished collectAll =\n");

	printArrayList();
	MPI_Barrier( MPI_COMM_WORLD );
	#endif
	
	struct Node *arraySort[nodeCount];
	short a = 0,i;
	for(i=0;a<nodeCount;i++)
		if(arraylist[i])
		{
			arraySort[a] = arraylist[i];
			a++;
		}


	#ifdef Presentation
	if(!MPI_id)
		printf("\n\t= Starting mergeSort =\n");
	#endif

	mergeSort(arraySort,nodeCount,0);

	#ifdef Presentation
	if(!MPI_id)
		printArrayList2(arraySort);
	MPI_Barrier( MPI_COMM_WORLD );
	#endif

	
	struct Node *huffArray[nodeCount-1];
	makeHuffmanTree(arraySort, huffArray);


	encode_Huffman(huffArray[nodeCount-2]);


	#ifdef Presentation
	if(!MPI_id)
	{
		printf("\n\t= Huffcode completed! =\n");
		printf("\n\t= Compressing! =\n");
	}
	MPI_Barrier( MPI_COMM_WORLD );	
	#endif

	/*#ifdef int_huff 
			#ifdef canonical_GPU_encoding
			canonical_encoding(arraySort);
			#endif
	//#endif */
	if(!MPI_id)
	{
		#ifdef int_huff
			#ifdef canonical_GPU_encoding
			canonical_encoding(arraySort);
			#endif
		compression_int(*fpsrc, fpdest,  fileLength);
		#else
		compression_char(*fpsrc, *fpdest, fileLength);
		#endif	
	}
	else if(MPI_id == 1 || MPI_size < 2)
	{
		#ifdef canonical_GPU_encoding
			serialize_canonical(*fpnode);
		#else
			serialize(*fpnode,arraySort);
		#endif
	}
	

	MPI_Barrier( MPI_COMM_WORLD );
	return 0;
}




int main(int argc, char *argv[])
{
	MPI_Init(&argc,&argv);
	MPI_Comm_size(MPI_COMM_WORLD,&MPI_size);
	MPI_Comm_rank(MPI_COMM_WORLD,&MPI_id);
	int i = 4,mp_size = MPI_size;
	
	
	if(MPI_size > 2)
	{
		while(mp_size > i)
				i+=i;

		if(mp_size != i)
		{
			if(!MPI_id)
				printf("\n\t!ERROR: -np '%d' must be a power of 2! = \n",mp_size);
			MPI_Finalize();
			return 2;
		}
	}

	MPI_File fpsrc,fpdest,fpnode;


	if(init(argc,argv,&fpsrc,&fpdest,&fpnode))
		return 1;

	#ifdef Presentation
	if(!MPI_id)
		printf("\n\t= Freeing Memory =\n");
	#endif

	for(i=0;i<arraySize;i++)
		if(arraylist[i])
		{
			#ifdef int_huff
			;
			#else
			free(arraylist[i]->huffman_code);
			#endif
			free(arraylist[i]);
		}
	
	MPI_File_close( &fpsrc );
	MPI_File_close( &fpdest );
	MPI_File_close( &fpnode );
	MPI_Finalize();
	return 0;
}
//enable this function by commenting out #define Presentation
// This function write the Huffman code to file as characters to make it easy to inspect by eye. 
void compression_char(MPI_File fpsrc, MPI_File fpdest, long fileLength)
{
	int buffSize = BUFSIZE;
	char *buf = (char*)malloc(sizeof(char)*buffSize);
	long position = 0;
	short i;
	int a;
	int numberOfBytes = fileLength;

	
	while((numberOfBytes - buffSize) > 0)
	{
		MPI_File_read_at(fpsrc, position, buf, buffSize, MPI_CHAR, &status );

		for(a=0; a < buffSize; a++) 
		{
			i = 255 & buf[a];
			MPI_File_write(fpdest, arraylist[i]->huffman_code, arraylist[i]->huffCodeCount, MPI_CHAR, &status ) ;
		}
		numberOfBytes = numberOfBytes - buffSize;
		position += buffSize;
	}

	if(numberOfBytes <  buffSize && numberOfBytes > 0)
	{
		buffSize = buffSize - (buffSize - numberOfBytes);

		MPI_File_read_at(fpsrc, position, buf, buffSize, MPI_CHAR, &status );
		for(a=0; a < buffSize; a++) 
		{
			i = 255 & buf[a];
			MPI_File_write(fpdest, arraylist[i]->huffman_code, arraylist[i]->huffCodeCount, MPI_CHAR, &status ) ;
		}
	}
	free(buf);	
}

void serialize(MPI_File fpnode, struct Node *array[])
{
	#ifdef Presentation
	printf("Serializing!\n");
	#endif

	int i;

	for(i=0;i<nodeCount;i++)
	{
		MPI_File_write(fpnode, &array[i]->Node_id, 1, MPI_SHORT, &status );
		MPI_File_write(fpnode, &array[i]->frequency, 1, MPI_INT, &status );
	}
	#ifdef Presentation
	printf("Finished Serializing!\n");
	#endif
}

void serialize_canonical(MPI_File fpnode)
{
	#ifdef Presentation
	printf("Serializing Canonical HuffMan!\n");
	#endif
	
	int i;
	char c = 0;

	for(i=0;i<arraySize;i++)
	{
		if(arraylist[i])
			MPI_File_write(fpnode, &arraylist[i]->huffCodeCount, 1, MPI_CHAR, &status );

		else
			MPI_File_write(fpnode, &c, 1, MPI_CHAR, &status );	
	}
	#ifdef Presentation
	printf("Finished Serializing Canonical HuffMan!\n");
	#endif
}


long swapLong(long in)
{
    long out;
    char *inp = (char *) &in ;
    char *outp = (char *) &out;

    size_t i;
	size_t sizeLong = sizeof(long);
	for (i=0; i<sizeLong ;i++)
	{    
	    outp[i] = inp[sizeLong-i-1]; 
	}

    return out;
}

//bug some where in it. helper function for compress_int()
void compression_int_logic(MPI_File *fpdest, short i, int amountOfBits,int *bits_remaining1,long *temp1)
{	
	long mask = 1;
	long temp = *temp1;
	int bits_remaining = *bits_remaining1;

	if (arraylist[i]->huffCodeCount < bits_remaining)
	{
		temp = temp << arraylist[i]->huffCodeCount;
		temp += arraylist[i]->huffman_code_int;
		bits_remaining -= arraylist[i]->huffCodeCount;
	}
	else
	{
		mask = mask << arraylist[i]->huffCodeCount;

		while(bits_remaining)
		{
			if(mask & arraylist[i]->huffman_code_int)
			{		
				temp = temp << 1;
				temp+=1;
			}
			else
				temp = temp << 1;
			mask = mask >> 1;
			bits_remaining--;
		}
		temp = swapLong(temp);
		MPI_File_write(*fpdest, &temp, 1, MPI_LONG, &status );

		bits_remaining = amountOfBits;
		temp = 0;
		while(mask)
		{
			if(mask & arraylist[i]->huffman_code_int)
			{		
				temp = temp << 1;
				temp+=1;
			}
			else
				temp = temp << 1;

			mask = mask >> 1;
			bits_remaining--;
		}
	}

	*temp1 = temp;
	*bits_remaining1 = bits_remaining;
}


// this function pushes the huffman code into a long variable. 
// when the long is completely filled it is then written to file
// at the end of the input file and unable to finish filling varible. 
// huffman code present in varible is pushed all the way to the left
void compression_int(MPI_File fpsrc, MPI_File *fpdest, long fileLength)
{
	#ifdef Presentation
	printf("starting Int Comression!\n");
	#endif
	int buffSize = BUFSIZE;
	//char buf [buffSize];
	char *buf = (char*)malloc(sizeof(char)*buffSize);
	
	long position = 0;
	short i;
	int a;
	int numberOfBytes = fileLength;
	long temp = 0;
	size_t temp_size = sizeof(long);
	int amountOfBits = temp_size*8;
	int bits_remaining = temp_size*8;
	long mask = 0;
	

	while((numberOfBytes - buffSize) > 0)
	{
		MPI_File_read_at(fpsrc, position, buf, buffSize, MPI_CHAR, &status );

		for(a=0; a < buffSize; a++)
		{
			i = 255 & buf[a];
			//compression_int_logic(fpdest, i, amountOfBits, &bits_remaining, &temp);
			///*
			if (arraylist[i]->huffCodeCount < bits_remaining)
			{
				temp = temp << arraylist[i]->huffCodeCount;
				temp += arraylist[i]->huffman_code_int;
				bits_remaining -= arraylist[i]->huffCodeCount;
			}
			else
			{
				mask = 1;
				mask = mask << arraylist[i]->huffCodeCount;
	
				while(bits_remaining)
				{
					if(mask & arraylist[i]->huffman_code_int)
					{		
						temp = temp << 1;
						temp+=1;
					}
					else
						temp = temp << 1;
					mask = mask >> 1;
					bits_remaining--;
				}

				temp = swapLong(temp);
				MPI_File_write(*fpdest, &temp, 1, MPI_LONG, &status );

				bits_remaining = amountOfBits;
				temp = 0;
				while(mask)
				{
					if(mask & arraylist[i]->huffman_code_int)
					{		
						temp = temp << 1;
						temp+=1;
					}
					else
						temp = temp << 1;

					mask = mask >> 1;
					bits_remaining--;
				}
			}//*/
		}
		numberOfBytes = numberOfBytes - buffSize;
		position += buffSize;
	}

	if(numberOfBytes <  buffSize && numberOfBytes > 0)
	{
		buffSize = buffSize - (buffSize - numberOfBytes);
		MPI_File_read_at(fpsrc, position, buf, buffSize, MPI_CHAR, &status);

		for(a=0; a < buffSize; a++)
		{
			i = 255 & buf[a];

			//compression_int_logic(fpdest, i, amountOfBits, &bits_remaining,&temp);
			//*
			if (arraylist[i]->huffCodeCount < bits_remaining)
			{
				temp = temp << arraylist[i]->huffCodeCount;
				temp += arraylist[i]->huffman_code_int;
				bits_remaining -= arraylist[i]->huffCodeCount;
			}
			else
			{
				mask = 1;
				mask = mask << arraylist[i]->huffCodeCount;
				while(bits_remaining)
				{
					if(mask & arraylist[i]->huffman_code_int)
					{		
						temp = temp << 1;
						temp+=1;
					}
					else
						temp = temp << 1;
					mask = mask >> 1;
					bits_remaining--;
				}

				temp = swapLong(temp);
				MPI_File_write(*fpdest, &temp, 1, MPI_LONG, &status );
				bits_remaining = temp_size*8;
				temp = 0;
				while(mask)
				{
					if(mask & arraylist[i]->huffman_code_int)
					{		
						temp = temp << 1;
						temp+=1;
					}
					else
						temp = temp << 1;
					mask = mask >> 1;
					bits_remaining--;
				}
			}//*/
		}//end of for

		if(bits_remaining)
		{
			temp = temp << bits_remaining;
			temp = swapLong(temp);
			MPI_File_write(*fpdest, &temp, 1, MPI_LONG, &status );
		}
	}

	#ifdef Presentation
	printf("finished Int Comression!\n");
	#endif
	free(buf);
}
/*
void parallel_compression_int(MPI_File fpsrc, MPI_File fpdest, long fileLength)
{

	int x = 1;
	int i;
	while(x)
	{

	}


}*/
/*
void canonical_encoding_helper(struct Node * array)
{
	int i,a,tag = 0;
	struct Node * temp;

	for(a = i; l == cancalArray[a]->huffCodeCount && a < nodeCount;a++)
	;

	
	for (c = i ; c < ( n - 1 ); c++)
	{
		for (d = 0 ; d < n - c - 1; d++)
		{
			if (array[d] > array[d+1])
			{
				temp       = array[d];
				array[d]   = array[d+1];
				array[d+1] = temp;
			}
		}
	}
}*/

void swap(struct Node * pointer1, struct Node *pointer2)
{
	struct Node * temp;
	temp = pointer1;
	pointer1 = pointer2;
	pointer2 = temp;
}


// this function is used to re-code the huffman code to allow the GPU portion of 
// the code to uses Canonical's parallel huffman decoding algorithm
// currently not working. 
void canonical_encoding(struct Node * cancalArray[])
{	
	int i,b;
	int a=0;
	int l = cancalArray[0]->huffCodeCount; 
	int begining_index = 0;
	struct Node * temp;

	printf("\nsorted by freqency\n");
	for(i=0;i<nodeCount;i++)
		printNode_encodeHuffman_int(cancalArray[i]);

	// sorts array by huffman code length
	mergeSort (cancalArray,nodeCount,1); 


	printf("\nsorted by huffman legnth\n");
	for(i=0;i<nodeCount;i++)
		printNode_encodeHuffman_int(cancalArray[i]);


	for(i=a; (i<nodeCount && l==cancalArray[i+1]->huffCodeCount); i++)
	{
		if(cancalArray[i]->Node_id > cancalArray[i+1]->Node_id)
		{
			swap(cancalArray[i],cancalArray[i+1]);
			i=i-2;
		}
		if(i < a)
		i=a;
	}
	a=i+1;

	printf("\nfirst sub sort\n");
	for(i=0;i<nodeCount;i++)
		printNode_encodeHuffman_int(cancalArray[i]);


	// sets first object to zeros
	cancalArray[0]->huffman_code_int = 0;
	begining_index=a;

	for(i=1;i<nodeCount;i++)
	{
		if(l == cancalArray[i]->huffCodeCount) // additional objects with same length are incremented
			cancalArray[i]->huffman_code_int = cancalArray[i-1]->huffman_code_int+1;

		else// for next longest huffman code. increment previous and shift left the difference in length
		{

			for(b=a; b<nodeCount && l == cancalArray[b+1]->huffCodeCount; b++)
			{
				if(cancalArray[b]->Node_id > cancalArray[b+1]->Node_id)
				{
					swap(cancalArray[b],cancalArray[b+1]);
					b=b-2;
				}
				if(b < a)
				b=a;
			}
			a=b+1;

			cancalArray[i]->huffman_code_int = cancalArray[i-1]->huffman_code_int+1;
			cancalArray[i]->huffman_code_int = cancalArray[i]->huffman_code_int << (cancalArray[i]->huffCodeCount - l); 
			l = cancalArray[i]->huffCodeCount;
			begining_index = i;
		}
	}


	printf("\n = PRINTING CANONICAL_ENCODING! = \n");
	for(i=0;i<nodeCount;i++)
		printNode_encodeHuffman_int(cancalArray[i]);
}



int lower(int x, int y)
{
    if(x < y)
        return x;
    else
        return y;
}

// im not proud of this, but i needed three different merge sorts. instead of making three 
// unique sorts, i decided to add this selector to differentiate the three sorts.
// 
int merge_selector(int left,int right,int r, int l , int length,int midpoint_distance, struct Node * input[], int selector)
{	
	if(selector)
	{
		if(selector == 1)// sorts by huffman code length
			if(l < left + midpoint_distance && (r == right || lower(input[l]->huffCodeCount, input[r]->huffCodeCount) == input[l]->huffCodeCount))
				return 1;
		else if(selector == 2)// sorts by node id
			if(l < left + midpoint_distance && (r == right || lower(input[l]->Node_id, input[r]->Node_id) == input[l]->Node_id))
				return 1;		
	}
	else// sorts by frequency
		if(l < left + midpoint_distance && (r == right || lower(input[l]->frequency, input[r]->frequency) == input[l]->frequency))
			return 1;

	return 0;
}

// Merge Sort. sorts lowest to highest
// if selector is 0, sort frequency, if == 1 sort huffman code length, if == 2 sort node_id
void merge(struct Node *input[], int left, int right, struct Node *temp[], int selector)
{
	if(right == left + 1)
		return;
	else
	{
		int i = 0;
		int length = right - left;
		int midpoint_distance = length/2;
		int l = left;
		int r = left + midpoint_distance;

		merge(input, left, left + midpoint_distance, temp, selector);
		merge(input, left + midpoint_distance, right, temp, selector);

		for(i = 0; i < length; i++)
		{
			//if(l < left + midpoint_distance && (r == right || lower(input[l]->frequency, input[r]->frequency) == input[l]->frequency))
			if( merge_selector(left, right, r, l , length, midpoint_distance, input, selector))
			{
				temp[i] = input[l];
				l++;
			}
			else
			{
				temp[i] = input[r];
				r++;
			}
		}

		for(i = left; i < right; i++)
			input[i] = temp[i - left];
	}
}


int mergeSort(struct Node *input[], int size, int selector)
{
    	//struct Node *temp = (struct Node*)malloc(sizeof(struct Node)*size);
	struct Node* temp[size];
		   
	if(temp)
	{
		merge(input, 0, size, temp, selector);
		//free(temp);
		return 1;
	}
	else
		return 0;
}




























