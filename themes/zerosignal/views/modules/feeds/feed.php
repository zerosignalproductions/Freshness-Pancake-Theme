<?php
echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>

    <title><?php echo $feed_name; ?></title>

    <link><?php echo $feed_url; ?></link>
    <description><?php echo $page_description; ?></description>
    <dc:language><?php echo $page_language; ?></dc:language>
    <dc:creator><?php echo $creator_email; ?></dc:creator>

    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />

    <?php foreach($invoices as $invoice): ?>
	<item>
		<title><?php echo xml_convert('Invoice #'.$invoice->invoice_number.' for '.$invoice->first_name.' '.$invoice->last_name); ?></title>
		<link><?php echo site_url($invoice->unique_id); ?></link>
		<guid><?php echo site_url($invoice->unique_id); ?></guid>

		<description><![CDATA[
			<?php echo 'Invoice #'.$invoice->invoice_number.' for '.$invoice->first_name.' '.$invoice->last_name; ?><br />
			<?php echo 'Amount Due: '.Currency::format($invoice->amount); ?><br />
			<?php echo 'Due Date: '.format_date($invoice->due_date); ?>
		]]></description>
		<pubDate><?php echo date ('r', $invoice->date_entered);?></pubDate>
	</item>
	<?php endforeach; ?>
</channel></rss>