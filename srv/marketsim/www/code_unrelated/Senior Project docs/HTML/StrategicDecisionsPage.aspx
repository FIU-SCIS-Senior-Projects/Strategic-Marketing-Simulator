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
.auto-style2 {
	text-align: left;
}
</style>
</head>

<body>

<form id="form1" runat="server" style="width: 838px; height: 580px">
	<div class="auto-style1">
		<br />
		<img alt="" height="31" src="Title.png" width="666" /><br />
		<br />
		<img alt="" height="31" src="StrategicDecisions.png" width="439" /><br />
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
&nbsp;<br />
		<br />
		<asp:Panel id="Panel2" runat="server" Height="349px" Width="809px">
			<div>
				<asp:Panel id="Panel3" runat="server" Height="149px" Width="199px">
					<div class="auto-style1" style="width: 199px; height: 152px">
						<br />
						<asp:Label id="Label1" runat="server" Text="Hiring Personnel"></asp:Label>
						<br />
						<br />
						<asp:Label id="Label2" runat="server" Text="Entree Level"></asp:Label>
						&nbsp;
						<asp:TextBox id="TextBox1" runat="server" Width="39px"></asp:TextBox>
						<br />
						<asp:Label id="Label3" runat="server" Text="Mid Level"></asp:Label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<asp:TextBox id="TextBox2" runat="server" Width="39px"></asp:TextBox>
						<br />
						<asp:Label id="Label4" runat="server" Text="High Level"></asp:Label>
						&nbsp;&nbsp;&nbsp;
						<asp:TextBox id="TextBox3" runat="server" Width="39px"></asp:TextBox>
					</div>
				</asp:Panel>
			</div>
		</asp:Panel>
		<br />
		<asp:Button id="Button1" runat="server" Text="Save" />
		<br />
		<br />
	</div>
</form>

</body>

</html>
