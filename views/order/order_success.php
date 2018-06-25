<?php
use app\models\TermekekSearch;1;
?>

    <h2>Köszönjük! A megrendelést megkaptuk</h2>

<?php
echo $this->render('_order_data', ['model' => $model]);

$dataProvider = (new TermekekSearch())->search(['subCategory' => ['ferfi-cipo', 'noi-cipo']]);
$dataProvider->pagination = false;
$dataProvider->query->andWhere(['opcio' => 'UJ']);
$dataProvider->query->limit(15);
$dataProvider->query->orderBy('rand()');

if ($dataProvider->getCount() > 0)
    echo $this->render('/termekek/_index_ajanlo', [
        'dataProvider' => $dataProvider,
    ]);

?>

<?php
// disabled coreshop user
if (Yii::$app->user->id != 11039 && isset($_SESSION["anaconvgeneral"]) && isset($_SESSION["anaconvitems"]) && isset($_SESSION["google_fizetendo"])) {
    $anaconvgeneral = $_SESSION["anaconvgeneral"];
    $anaconvitems = $_SESSION["anaconvitems"];
    $orderPrice = $_SESSION["google_fizetendo"];
    ?>
    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-17488049-1', 'auto');
        ga('require', 'displayfeatures');
        ga('require', 'linkid', 'linkid.js');
        ga('send', 'pageview');

        ga('require', 'ecommerce', 'ecommerce.js');

        // Initialize the transaction
        ga('ecommerce:addTransaction', {
            id: '<?php echo($anaconvgeneral['invoice']); ?>',     // Transaction ID*
            affiliation: '', // Store Name
            revenue: '<?php echo($anaconvgeneral['totalnovat']); ?>',       // Total
            shipping: '<?php echo($anaconvgeneral['shipping']); ?>',          // Shipping
            tax: '<?php echo($anaconvgeneral['totalvat']); ?>'         // Tax
        });


        <?php
        if ($anaconvitems)
        foreach($anaconvitems as $item) :
        ?>

        ga('ecommerce:addItem', {
            id: '<?php echo($anaconvgeneral['invoice']); ?>',            // Transaction ID*
            sku: '<?php echo $item['SKU']; ?>',         // Product SKU
            name: '<?php echo $item['productname']; ?>',   // Product Name*
            category: '',      // Product Category
            price: '<?php echo $item['itemprice']; ?>',              // Price
            quantity: '<?php echo $item['itemqty']; ?>'                   // Quantity
        });

        <?php
        endforeach;
        ?>

        ga('ecommerce:send');

    </script>


    <!-- Google Code for sikeres vasarlas Conversion Page -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 1010416024;
        var google_conversion_language = "en";
        var google_conversion_format = "1";
        var google_conversion_color = "000000";
        var google_conversion_label = "TCuVCJC_0QEQmPPm4QM";
        <?php if($orderPrice): ?>
        var google_conversion_value = <? echo $orderPrice?>;
        <?php endif; ?>
        var google_conversion_currency = "HUF";
        var google_remarketing_only = false;

        /* ]]> */
    </script>
    <script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="https://www.googleadservices.com/pagead/conversion/1010416024/?value=<?= $orderPrice ?>?&amp;currency_code=HUF&amp;label=TCuVCJC_0QEQmPPm4QM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
    <!-- -->


    <!-- Facebook Conversion Code for Sikeres vásárlás -->
    <script>(function () {
            var _fbq = window._fbq || (window._fbq = []);
            if (!_fbq.loaded) {
                var fbds = document.createElement('script');
                fbds.async = true;
                fbds.src = '//connect.facebook.net/en_US/fbds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(fbds, s);
                _fbq.loaded = true;
            }
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', '6018444862384', {
            'value': '<?=$orderPrice?>.00',
            'currency': 'HUF'
        }]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none"
                   src="https://www.facebook.com/tr?ev=6018444862384&amp;cd[value]=<?= $orderPrice ?>&amp;cd[currency]=HUF&amp;noscript=1"/>
    </noscript>


    <!-- facebook konverzio_2017 -->
    <script>
        fbq('track', 'Purchase', {value: '<?=$orderPrice?>.00', currency: 'HUF'});
    </script>


    <?php
    unset($_SESSION["anaconvgeneral"]);
    unset($_SESSION["anaconvitems"]);
    unset($_SESSION["google_fizetendo"]);
}
?>
