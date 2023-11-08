<?php

use Framework\Database\Database;
use Framework\models\PostModel;
use Framework\Router\Exceptions\InternalServerErrorException;

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
    <section class="content">
      <div class="row">
        <section class="col-lg-12 connectedSortable ui-sortable">
          <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
              <h3 class="card-title">
                <i class="fas fa-database"></i>
                Data
              </h3>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
              <?php
                foreach($posts as $post):
                  echo  '<br />'. $post->title;
                endforeach;
              ?>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>
  </div>

  <?php require_once __DIR__ . '/inc/footer.php'; ?>