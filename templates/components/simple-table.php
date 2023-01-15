<div class="main_container entries">
        <?php if ( !empty($head) ) : ?>
          <h1><?php echo $head ?></h1>
        <?php endif; ?>
        <table>
          <?php foreach ($jobs as $key => $job) : ?>
            <?php if ($key == 0) : ?>
              <thead>
                <tr>
                  <?php foreach ($job as $k => $v) : ?>
                    <th>
                      <?php 
                      if ($k == 'id') { ?>
                        Actions 
                      <?php } else {
                        echo $k;
                      }
                      ?> 
                    </th>
                  <?php endforeach; ?>
                </tr>
              </thead>

              <tbody>
            <?php endif; ?>
            <tr>
              <?php foreach ($job as $k => $v) : ?>
                <td>
                  <?php 
                  if ($k == 'id') { 
                    $post_url = add_query_arg( array( 
                      'page'   => 'main_add_job', 
                      'main_id' => $v, 
                    ), admin_url( 'admin.php' ) );
                    ?>
                    <a href="<?php echo $post_url ?>">Edit</a>  
                  <?php } else {
                    echo $v;
                  }
                  ?>  
                </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>