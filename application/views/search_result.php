<?php echo '<p id="search-header" class="search-header">search results for : <span> "'.$_SESSION['search_request'].'" </span> </p>'; ?>
<?php foreach ($data as $key => $value): ?>
<div id="search-area" class="search-area">
 <h3 id="search-link" class="search-link"><a href='/post_page/<?=substr(utf8_encode($value["post_id"]), 0,10);?>'><?=stripslashes(substr(utf8_encode($value["post_title"]), 0));?></a></h3><p>
 <?=stripslashes(substr(utf8_encode($value["post_content"]), 0,70));?>....</p></div>
<?php endforeach; ?>