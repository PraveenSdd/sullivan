<?php echo $this->element('email/header'); ?>

<table style="width:100%;background-color:#ffffff;border-radius:3px;" cellpadding="15" cellspacing="0">
                	<tr>
                    	<td>
                        	<table style="width:90%;margin:0 auto;" cellpadding="15" cellspacing="0">
                                <tr>
                                    <td>
                                        <!--<img src="tick.png" alt="" />-->
                                        <h2 style="font-family:'Open Sans', sans-serif;font-weight:600;color:#64646e;font-size:18px;margin-bottom:0;margin-top:5px;">Successfully Registered!</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:'Open Sans', sans-serif;color:#64646e;font-size:14px;text-align:left;">Hello <?php echo $data['name']?>,</td>
                                </tr>
                                <tr>
                                    <td style="font-family:'Open Sans', sans-serif;color:#64646e;font-size:14px;text-align:left;">    Please Click on this button for verify email and active account.</td>
                                </tr>
                                <tr>
                                    <td style="font-family:'Open Sans', sans-serif;color:#64646e;font-size:14px;text-align:left;">    Your Password : <?= $data['password']?>.</td>
                                </tr>
                                <tr>
                                    <td><p style="border-top:1px solid #cccccc;margin-bottom:0;">&nbsp;</p></td>
                                </tr>
                                <tr>
                                   <td align='center'><a href="<?= BASE_URL?>/admin/users/emailVerification/<?php echo $data['token']; ?>" style="font-family:'Open Sans', sans-serif;color:#ffffff;font-size:14px;font-weight:600;background-color:#09347a;padding:10px 20px;border-radius:3px;text-decoration:none;width:auto;display:inline-block;margin:0 auto;"> Click for email verfication</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
   <?php echo $this->element('email/footer'); ?>