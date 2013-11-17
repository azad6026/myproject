<div id="pagination" class="pagination">
      <?php if($data['has_previous_page']==true) :?>
 	        <span><a class='paginated_page' href='/<?=$data['page_name']?>/<?=$data['previous_page']?>'>&laquo; Previous &nbsp</a>
 	 	<?php endif; ?>
 		</span>
 		<span>
    		<?php for($i=1;$i<=$data['total_pages'];$i++) {
    		if($i==$data['current_page']){ ?>
    		<span class="current_page"><?=$data['current_page']?></span>
    		<?php }else{ ?>
    		<a class='paginated_page' href='/<?=$data['page_name']?>/<?=$i?>'><?=$i?></a>
    		<?php }
    		} ?>
    		</span>
 		<span>
 		<?php if($data['has_next_page']==true) :?>
 	        <a class='paginated_page' href='/<?=$data['page_name']?>/<?=$data['next_page']?>'> &nbsp Next &raquo;</a>
 	 	<?php endif; ?>
 		</span>
</div>


	