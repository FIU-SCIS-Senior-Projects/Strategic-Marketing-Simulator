

all: test

test:	test.c
	mpicc test.c -o test


clean:
	$(RM) test *.o *.huff *.node *.txt *~

run2:
#	make clean
#	make
	mpirun -np 2 ./test SourceFile DestFile > out.txt
run_2:
	mpirun -np 2 ./test test.c DestFile > out.txt
run_4:
	mpirun -np 4 ./test test.c DestFile > out.txt
run4:
	mpirun -np 4 ./test SourceFile DestFile > out.txt
run_8:
	mpirun -np 8 ./test test.c DestFile > out.txt
run8:
	mpirun -np 8 ./test SourceFile DestFile > out.txt
run_16:
	mpirun -np 16 ./test test.c DestFile > out.txt
run16:
	mpirun -np 16 ./test SourceFile DestFile > out.txt
run155:
	mpirun -np 155 ./test SourceFile DestFile

run_game:
	mpirun -np 2 ./test game.of.thrones.s04e01.hdtv.x264-killers.mp4 DestFile > out.txt

run_code:# compresses executable
	mpirun -np 2 ./test test DestFile > out.txt
