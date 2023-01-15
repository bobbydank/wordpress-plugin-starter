<ul class="main-flex-table">
      <li>
        <ul class="head entry">
          <li>Position</li>
          <li>Department</li>
          <li>Type</li>
          <li>Location</li>
        </ul>
      </li>
      <?php foreach ($jobs as $key => $job) : 
        $seperator = '';
        if (!empty($job->city)) {
          $seperator = ', ';
        }
        ?>
      <li>
        <a href="<?php echo get_bloginfo('url'); ?>/job/?jid=<?php echo $job->jobid; ?>">
          <ul class="row entry">
            <li><?php echo $job->name ?></li> 
            <li><?php echo $job->department ?></li>
            <li><?php echo $this->_un_codify($job->career_type); ?></li>
            <li><?php echo $job->city . $seperator . $job->state; ?></li>
          </ul>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>