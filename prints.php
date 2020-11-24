<!DOCTYPE html>
<html>

<head>
    <title>Mencetak Sebagian Dokumen dengan JavaScript</title>

    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

</head>

<body>

    <h1>Tutorialweb</h1>
    <div id="div1">Tutorial Pemrograman PHP</div>
    <button onclick="printContent('div1')">Print</button>

    <div id="div2">Tutorial JavaScript</div>
    <button onclick="printContent('div2')">Print</button>

    <p id="p1">Developh Website</p>
    <button onclick="printContent('p1')">Print</button>

</body>

</html>