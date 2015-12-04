<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Image_title</title>
<style type="text/css">
.auto-style1 {
	text-align: center;
}
</style>
</head>

<body>

<form id="form1" runat="server" style="width: 838px; height: 580px">
	<div class="auto-style1">
		<br />
		<br />
		<input height="31" name="Image_Title" src="Title.png" type="image" width="666" /><br />
		<br />
		<br />
		<asp:Panel id="Panel_Toolbar" runat="server" BackColor="Silver" BorderColor="Black" Font-Underline="False" Height="31px" Width="835px">
			<asp:Button id="Button_Home" runat="server" Text="Home" />
			&nbsp;&nbsp;
			<asp:Button id="Button_Metrics" runat="server" Text="Metrics" />
			&nbsp;&nbsp;
			<asp:Button id="Button_strategicDecisions" runat="server" Text="Strategic Decisions" />
			&nbsp;&nbsp;
			<asp:Button id="Button_manage" runat="server" Text="Manage" />
			&nbsp;&nbsp;
			<asp:Button id="Button_News" runat="server" Text="News" />
			&nbsp;&nbsp;
			<asp:Button id="Button_Signout" runat="server" Text="Sign Out" />
		</asp:Panel>
&nbsp;<div class="auto-style1">
		</div>
		<br />
		<br />
		<asp:Panel id="Panel2" runat="server" Height="349px" Width="809px">
			<asp:Panel id="Panel_scorecard" runat="server" BorderColor="Silver" Height="168px">
				<asp:Label id="Label_scorecard_title" runat="server" Text="ScoreCard"></asp:Label>
				<br />
				<asp:Panel id="Panel3" runat="server" Height="115px" Width="791px">
				</asp:Panel>
				<br />
				<br />
				<asp:Label id="Label1" runat="server" Text="LeaderBoard"></asp:Label>
				<asp:Panel id="Panel4" runat="server" Height="117px" Width="794px">
					<asp:ListBox id="ListBox1" runat="server" Width="573px">
						<asp:ListItem>home</asp:ListItem>
						<asp:ListItem>gggg</asp:ListItem>
						<asp:ListItem>2</asp:ListItem>
						<asp:ListItem>3</asp:ListItem>
						<asp:ListItem>4</asp:ListItem>
						<asp:ListItem>5</asp:ListItem>
						<asp:ListItem>6</asp:ListItem>
						<asp:ListItem>1</asp:ListItem>
						<asp:ListItem>7</asp:ListItem>
						<asp:ListItem>8</asp:ListItem>
						<asp:ListItem>9</asp:ListItem>
					</asp:ListBox>
				</asp:Panel>
				<br />
			</asp:Panel>
		</asp:Panel>
		<br />
		<br />
		<br />
	</div>
</form>

</body>

</html>
