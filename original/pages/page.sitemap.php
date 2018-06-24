<?

class SimpleXMLExtended extends SimpleXMLElement {

    public function addCData($cdata_text) {
        $node = dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }

}

//<item xmlns:msxsl="urn:schemas-microsoft-com:xslt" xmlns:scrpt="www.mindennapi.hu">

ob_end_clean();
ob_start();
$newsXML = new SimpleXMLExtended("<news></news>");
$newsXML->addAttribute('newsPagePrefix', 'value goes here');

$newsIntro = $newsXML->addChild('item');
$newsIntro->addAttribute('xmlns:msxsl', 'urn:schemas-microsoft-com:xslt');
$newsIntro->addAttribute('xmlns:scrpt', 'coreshop.hu');

$title = $newsXML->addChild('title');
$title->addCData('title');

$link = $newsXML->addChild('title', 'http');

$desc = $newsXML->addChild('description');
$desc->addCData('description');

$guid = $newsXML->addChild('guid', 1111);

$date = $newsXML->addChild('pubDate', date("r", strtotime('2017-11-11')));

$cat = $newsXML->addChild('category');
$cat->addCData('category');

$hst = $newsXML->addChild('hst:titlepage');
$hst->addCData('1');

//Header('Content-type: text/xml');
//echo $newsXML->asXML();

while ($lista = mysql_fetch_array($sitemap->lista_query)) {
    //$termekek->echoProductTM($lista);
    //echo $lista['id'];
    var_dump($lista);
    die;
    //print_r($lista);
    //echo $lista['id'];
}
ob_flush();
die;
