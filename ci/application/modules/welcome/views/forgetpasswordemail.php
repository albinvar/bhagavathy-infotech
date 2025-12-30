<div style='background: #f2f2f2;color:#666; padding:25px 20px;margin: 0 auto;max-width: 800px;'>
    <div>
        <div style='width:95%; margin: 0px auto;'>
            <img src="<?=base_url()?>components/images/logo.png" />
        </div>
        <div
            style='background: #fff;color: #5b5b5b;border-radius: 4px;font-family: arial;font-size: 13px;padding: 10px 20px;width: 90%;margin: 20px auto;line-height: 17px;border: 1px #ddd solid;border-top: 0;clear: both;'>
            <p>Hi <?=$firstname . ' ' . $lastname?>,</p><br>
            <p>
                Please use the below url to set your new password 
            </p><br>
     
            
            <p><a href="<?=base_url()?>welcome/resetpassword/<?=$authid?>/<?=$auth?>"><?=base_url()?>welcome/resetpassword/<?=$authid?>/<?=$auth?></a></p>

               

                Good luck!

                <br>
            <p style='font-weight:bold;'>
                Thank you!<br>
                Team <?=WEBSITE_NAME?><br>
                Website : <?=SITE_URL?><br>
                Email : <?=CONTACT_EMAIL?><br>
                <a href="<?=base_url()?>"><?=WEBSITE_NAME?></a>
            </p>



            <p>
                ----------------------------------------------------------------------------------------------------------------------------------------------------
            </p>
            <p>
                This email, together with any attachments, is for the exclusive and confidential use of the addressee(s)
                and may contain privileged information. Any other distribution, use or reproduction without the sender's
                prior consent is unauthorised and strictly prohibited. If you have received this message in error,
                please notify the sender by email immediately and delete the message from your system without making any
                copies.
            </p>
        </div>
        <p style='margin-top:10px;margin-left:21px;margin-right:22px;'> Copyright &copy; <?=WEBSITE_NAME?>
            <?=date('Y')?>. All Rights Reserved <span style='float:right;'><span></p>
    </div>
</div>