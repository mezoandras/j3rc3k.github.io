<?php
header("Content-Type: application/rss+xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0">
  <channel>
    <title>J3RC3K</title>
    <link>https://j3rc3k.eu/</link>
    <description>Legfrissebb hírek</description>
    <language>hu-hu</language>

    <?php
    $hirek = [
        ["title" => "Első hír", "link" => "https://www.sajatweboldal.hu/elso-hir", "description" => "Ez az első hír.", "date" => "Mon, 27 Jan 2025 12:00:00 GMT"],
        ["title" => "Második hír", "link" => "https://www.sajatweboldal.hu/masodik-hir", "description" => "Ez a második hír.", "date" => "Tue, 28 Jan 2025 10:30:00 GMT"],
    ];

    foreach ($hirek as $hir) {
        echo "<item>";
        echo "<title>{$hir['title']}</title>";
        echo "<link>{$hir['link']}</link>";
        echo "<description>{$hir['description']}</description>";
        echo "<pubDate>{$hir['date']}</pubDate>";
        echo "</item>";
    }
    ?>
  </channel>
</rss>
