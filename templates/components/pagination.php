<div class="counter">
        <p>Showing <?php echo (($current - 1) * $posts_per) + 1 ?> - <?php echo $current * $posts_per ?> of <?php echo $full_count; ?></p>
      </div>
      <ul class="pagination">
        <?php //prev
        if ($current_page_num != 1) : 
          $get['main_jobs_page'] = $current_page_num - 1;
          $u = sprintf($url.'?%s', http_build_query($get));
          ?>
          <li><a href="<?php echo $u ?>">&laquo; Prev</a></li>
        <?php endif; ?>

        <li>
          <select onchange="if (this.value) window.location.href=this.value">
            <?php for ($x = 1; $x <= $num_of_pages; $x++) : 
              $get['main_jobs_page'] = $x; ?>
              <option <?php echo ($x == $current_page_num) ? 'selected="selected"' : ''; ?> value="<?php echo sprintf($url.'?%s', http_build_query($get)); ?>">
                <?php echo $x; ?>
              </option>
            <?php endfor; ?>
          </select>
        </li>

        <?php //first three 
        /* for ($x = 1; $x < ($current_page_num * 25); $x++) : ?>
        <li>
          <?php if ($x != $current_page_num) : 
            $get['main_jobs_page'] = $x;
            $url = admin_url(sprintf('admin.php?%s', http_build_query($get)));
            ?>
            <a href="<?php echo $url ?>">
          <?php endif;
            
            echo $x;
          
          if ($x != $current_page_num) : ?>
            </a>
          <?php endif; ?>
        </li>
        <?php endfor; */ ?>

        <?php //next
        if ( !(($current_page_num * $posts_per) > ($full_count + 1) )) : 
          $get['main_jobs_page'] = $current_page_num + 1;
          $u = sprintf($url.'?%s', http_build_query($get));
          ?>
          <li><a href="<?php echo $u ?>">Next &raquo;</a></li>
        <?php endif; ?>
      </ul>