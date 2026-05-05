<?php 

get_header(); 

$current_category = get_queried_object();
?>
<div class="white-wrap">
   <div id="app" data-id = "<?php echo $current_category->term_id; ?>">
      <router-view></router-view>
   </div>
</div>
<template id="post-list-template">
   <div class="container">
      <div class="post-list">
         <article v-for="post in posts" class="post">
            <a href="{{post.link}}">
            <img v-bind:src="post.fi_300x180">
            </a>
            <div class="post-content">
               <h2>{{ post.title.rendered }}</h2>
               <small v-for="category in post.cats">
               {{ category.name }}
               </small>
            </div>
         </article>
      </div>
      <div class="pagination">
         <span>Page {{currentPage}} of {{allPages}}</span>
         <button class="btn" v-on:click="getPosts(prev_page)" :disabled="!prev_page">
         Previous
         </button>
         <button class="btn" v-on:click="getPosts(next_page)" :disabled="!next_page">
         Next
         </button>
      </div>
   </div>
   
</template>

<?php get_footer(); ?>