<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Image_title</title>
<style type="text/css">
.auto-style2 {
	margin-top: 0px;
}
.auto-style3 {
	text-align: center;
}
</style>
</head>

<body>

<form id="form1" runat="server" style="width: 850px; height: 580px">
	<div class="auto-style3">
		<br />
		<br />
		<input height="31" name="Image_Title" src="Title.png" type="image" width="666" /><br />
		<br />
		<img alt="" height="24" src="News.png" width="112" /><br />
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
		<asp:Panel id="Panel2" runat="server" Height="354px" Width="819px" BorderColor="Silver" CssClass="auto-style2">
		</asp:Panel>
		<br />
		<br />
		<br />
	</div>
</form>

</body>

</html>
