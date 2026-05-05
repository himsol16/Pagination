<?php get_header(); 
   $categories = get_the_category();
   $category_id = $categories[0]->cat_ID;
   
   ?>
<div class="white-wrap">
   <div id="app" data-id = "<?php echo $category_id; ?>">
      <router-view></router-view>
   </div>
</div>
<template id="post-list-template">
   <div class="overlay" v-if="show" transition="overlayshow"></div>
   <header class="main-header">
      <img class="hero" src="<?php bloginfo('template_url'); ?>/images/hero.jpg" alt="">    
   </header>
   <div class="container">
      <div class="post-list">
         <article v-for="post in posts" class="post">
           
               <a href="{{post.link}}" @click='getThePost(post.id)'>
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
   <div class="single-preview" v-if="show" transition="postshow">
      <h2>{{ post[0].title.rendered }}</h2>
      <div class="image">
         <img v-bind:src="post[0].full">
      </div>
      <div class="post-content">
         {{{ post[0].excerpt.rendered }}}
         <a v-link="{name:'post', params:{postID: post[0].id }}" class="btn-read-more">Read more</a>
      </div>
      <a v-on:click="getThePost(post[0].next_post)" v-if="post[0].next_post" class="post-nav next">
      <span class="icon-right"></span>
      </a>
      <a v-on:click="getThePost(post[0].previous_post)" v-if="post[0].previous_post" class="post-nav prev">
      <span class="icon-left"></span>
      </a>
      <button class="close-button" v-on:click="closePost()">&#215;</button>
   </div>
</template>
<template id="single-post-template">
   <div class="post-control">
      <div class="container">
         <a v-link="{path: '/'}" class="btn-read-more">Back to post list</a>
      </div>
      <a v-link="{ name: 'post', params:{ postID: post.next_post}}" v-if="post.next_post" class="post-nav next">
      <span class="icon-right"></span>
      </a>
      <a v-link="{ name: 'post', params:{ postID: post.previous_post}}" v-if="post.previous_post" class="post-nav prev">
      <span class="icon-left"></span>
      </a>
   </div>
   <div class="container single-post">
      <h2 class="title">{{ post.title.rendered }}</h2>
      <div class="image">
         <img v-bind:src="post.full">
      </div>
      <div class="post-content">
         {{{ post.content.rendered }}}
      </div>
   </div>
</template>
<?php get_footer(); ?>