<?php
if(!defined("GALAXYSERVERS")) { die("Você não pode acessar esse arquivo."); }
$bodyEmailA = "<!doctype html>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
<head>
	<meta charset='UTF-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<style type='text/css'>
	a{ 
		text-decoration:none;
	} 
	p{
		margin:10px 0;
		padding:0;
	}
	table{
		border-collapse:collapse;
	}
	h1,h2,h3,h4,h5,h6{
		display:block;
		margin:0;
		padding:0;
	}
	img,a img{
		border:0;
		height:auto;
		outline:none;
		text-decoration:none;
	}
	body,#bodyTable,#bodyCell{
		height:100%;
		margin:0;
		padding:0;
		width:100%;
	}
	#outlook a{
		padding:0;
	}
	img{
		-ms-interpolation-mode:bicubic;
	}
	table{
		mso-table-lspace:0pt;
		mso-table-rspace:0pt;
	}
	.ReadMsgBody{
		width:100%;
	}
	.ExternalClass{
		width:100%;
	}
	p,a,li,td,blockquote{
		mso-line-height-rule:exactly;
	}
	a[href^=tel],a[href^=sms]{
		color:inherit;
		cursor:default;
		text-decoration:none;
	}
	p,a,li,td,body,table,blockquote{
		-ms-text-size-adjust:100%;
		-webkit-text-size-adjust:100%;
	}
	.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
		line-height:100%;
	}
	a[x-apple-data-detectors]{
		color:inherit !important;
		text-decoration:none !important;
		font-size:inherit !important;
		font-family:inherit !important;
		font-weight:inherit !important;
		line-height:inherit !important;
	}
	#bodyCell{
		padding:10px;
	}
	.templateContainer{
		max-width:600px !important;
	}
	a.mcnButton{
		display:block;
	}
	.mcnImage{
		vertical-align:bottom;
	}

	.mcnTextContent{
		word-break:break-word;
	}
	.mcnTextContent img{
		height:auto !important;
	}
	.mcnDividerBlock{
		table-layout:fixed !important;
	}
	body,#bodyTable{
		/*@editable*/
		background-color: #efefef;
	}
	#bodyCell{
		/*@editable*/border-top:0;
	}
	.templateContainer{
		/*@editable*/border:0;
	}
	h1{
		/*@editable*/color:#202020;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:26px;
		/*@editable*/font-style:normal;
		/*@editable*/font-weight:bold;
		/*@editable*/line-height:125%;
		/*@editable*/letter-spacing:normal;
		/*@editable*/text-align:left;
	}
	h2{
		/*@editable*/color:#202020;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:22px;
		/*@editable*/font-style:normal;
		/*@editable*/font-weight:bold;
		/*@editable*/line-height:125%;
		/*@editable*/letter-spacing:normal;
		/*@editable*/text-align:left;
	}
	h3{
		/*@editable*/color:#202020;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:20px;
		/*@editable*/font-style:normal;
		/*@editable*/font-weight:bold;
		/*@editable*/line-height:125%;
		/*@editable*/letter-spacing:normal;
		/*@editable*/text-align:left;
	}
	h4{
		/*@editable*/color:#202020;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:18px;
		/*@editable*/font-style:normal;
		/*@editable*/font-weight:bold;
		/*@editable*/line-height:125%;
		/*@editable*/letter-spacing:normal;
		/*@editable*/text-align:left;
	}
	#templatePreheader{
		/*@editable*/background-color:#FAFAFA;
		/*@editable*/border-top:0;
		/*@editable*/border-bottom:0;
		/*@editable*/padding-top:9px;
		/*@editable*/padding-bottom:9px;
	}
	#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
		/*@editable*/color:#656565;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:12px;
		/*@editable*/line-height:150%;
		/*@editable*/text-align:left;
	}
	#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
		/*@editable*/color:#656565;
		/*@editable*/font-weight:normal;
		/*@editable*/text-decoration:underline;
	}
	#templateHeader{
		/*@editable*/background-color:#FFFFFF;
		/*@editable*/border-top:0;
		/*@editable*/border-bottom:0;
		/*@editable*/padding-top:9px;
		/*@editable*/padding-bottom:0;
	}
	#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
		/*@editable*/color:#202020;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:16px;
		/*@editable*/line-height:150%;
		/*@editable*/text-align:left;
	}
	#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
		/*@editable*/color:#2BAADF;
		/*@editable*/font-weight:normal;
		/*@editable*/text-decoration:underline;
	}
	#templateBody{
		/*@editable*/background-color:#FFFFFF;
		/*@editable*/border-top:0;
		/*@editable*/border-bottom:2px solid #EAEAEA;
		/*@editable*/padding-top:0;
		/*@editable*/padding-bottom:9px;
	}
	#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
		/*@editable*/color:#202020;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:16px;
		/*@editable*/line-height:150%;
		/*@editable*/text-align:left;
	}
	#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
		/*@editable*/color:#2BAADF;
		/*@editable*/font-weight:normal;
		/*@editable*/text-decoration:underline;
	}
	#templateFooter{
		/*@editable*/background-color:#FAFAFA;
		/*@editable*/border-top:0;
		/*@editable*/border-bottom:0;
		/*@editable*/padding-top:9px;
		/*@editable*/padding-bottom:9px;
	}
	#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
		/*@editable*/color:#656565;
		/*@editable*/font-family:Helvetica;
		/*@editable*/font-size:12px;
		/*@editable*/line-height:150%;
		/*@editable*/text-align:center;
	}
	#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
		/*@editable*/color:#656565;
		/*@editable*/font-weight:normal;
		/*@editable*/text-decoration:underline;
	}
</style></head>
<body>
	<center>
		<table align='center' border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable'>
			<tr>
				<td align='center' valign='top' id='bodyCell'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
						<tr>
							<center><img align='' alt='' src='https://i.imgur.com/JSOd6Vi.png' draggable='false' class='' style=' width: 25%; '></center>
													<tr>
								<td valign='top' id='templateHeader'><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnBoxedTextBlock' style='min-width:100%;'>
									<tbody class='mcnBoxedTextBlockOuter'>
										<tr>
											<td valign='top' class='mcnBoxedTextBlockInner'>
												<table align='left' border='0' cellpadding='0' cellspacing='0' width='100%' style='min-width:100%;' class='mcnBoxedTextContentContainer'>
													<tbody>
														<tr>
															<td style='padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;'>
																<table border='0' cellpadding='18' cellspacing='0' class='mcnTextContentContainer' width='100%' style='min-width: 100% !important;background-color: #FFFFFF;'>
																	<tbody>
																		<tr>
																			<td valign='top' class='mcnTextContent' style='color: #2A2A2A;font-family: Helvetica;font-size: 14px;font-weight: normal;text-align: center;'>
																				<span style='font-size:24px'>Olá, %usuario% (%nomehotel%).</span>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td valign='top' id='templateBody'><table border='0' cellpadding='0' cellspacing='0' width='100%' class='mcnTextBlock' style='min-width:100%;'>
								<tbody class='mcnTextBlockOuter'>
									<tr>
										<td valign='top' class='mcnTextBlockInner'>
											<table align='left' border='0' cellpadding='0' cellspacing='0' width='100%' style='min-width:100%;' class='mcnTextContentContainer'>
												<tbody><tr>
													<td valign='top' class='mcnTextContent' style='padding-top:2px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;'>
														%conteudo%
													</td>
													<br>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</center>
</body>
</html>";
?>