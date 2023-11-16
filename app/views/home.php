<?php
use Framework\Router\URL\Error;
require_once __DIR__ . '/inc/header.php'; ?>
<div class="wrapper">
  <div class="content-wrapper" style="min-height: 554.667px;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Admin</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="col-lg-12 connectedSortable ui-sortable">
      <?php
      // Display any messages
      if (Error::has('primary_message')) {
        Error::setMessage('primary_message');
      } ?>
      <div class="card">
        <div class="container">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-database"></i>
              Data
            </h3>
          </div>

          <table class="table">

            <thead>

              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
              </tr>
            </thead>
            <div class="row">
              <?php
              if (is_array($posts) || is_object($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                  <tbody>
                    <tr>
                      <td><?php echo $post->id ?></td>
                      <td><?php echo $post->title ?></td>
                      <td><?php echo $post->content ?></td>
                    </tr>
                  </tbody>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </table>
        </div>
      </div>
    </section>

  </div>

  <?php require_once __DIR__ . '/inc/footer.php'; ?>