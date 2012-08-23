        
<?php
    //Account for the different ways Pancake addresses client data

    if(isset($invoice)) {
        $client_info = array(
            'company' => $invoice['company'],
            'address' => $invoice['address'],
            'name' => $invoice['first_name'].' '.$invoice['last_name'],
            'email' => $invoice['email'],
            'phone' => $invoice['phone']
        );
    } elseif(isset($client)) {
        if(is_array($client)) {
            $client_info = array(
                'company' => $client['company'],
                'address' => $client['address'],
                'name' => $client['first_name'].' '.$client['last_name'],
                'email' => $client['email'],
                'phone' => $client['phone']
            );
        } else {
            $client_info = array(
                'company' => $client->company,
                'address' => $client->address,
                'name' => $client->first_name.' '.$client->last_name,
                'email' => $client->email,
                'phone' => $client->phone
            );
        }
    }
?>
        
<table class="invoice-contact">
    <tr class="row">
        <td id="company-info-holder">
            <ul class="info">
                <li class="logo"><?php echo logo(false, false, 2);?></li>
                <li class="address"><h5>Address:</h5> <?php echo nl2br(Settings::get('mailing_address')); ?></li>
                <li class="phone"><h5>Phone:</h5> </li>
                <li class="email"><h5>Email:</h5> <?php echo nl2br(Settings::get('notify_email')); ?></li>
                <li class="fax"><h5>Fax:</h5> </li>
            </ul>
        </td>

        <td id="invoice-details-holder">
            <div id="clientInfo">
                <div id="billing-info">
                    <ul class="info">
                        <?php if($client_info['company']): ?>
                            <li class="logo"><h2><?php echo $client_info['company'];?></h2></li>
                        <?php endif; ?>
                        <li class="address"><h5>Address: </h5><?php echo nl2br($client_info['address']);?></li>
                        <li><h5>Contact: </h5> <?php echo $client_info['name'];?></li>
                        <li class="email"><h5>Email:</h5> <?php echo $client_info['email']; ?></li>
                        <li class="client-phone"><h5>Phone:</h5> <?php echo $client_info['phone']; ?></li>
                    </ul>
                </div>
            </div><!-- /clientInfo -->
        </td>                        
    </tr>
</table>