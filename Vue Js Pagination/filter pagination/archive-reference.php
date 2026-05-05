<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package berger
 */

get_header();
$theme_path = get_template_directory_uri();?>
<div class="header-shape"></div>
<section class="ref-grid-sec">
	<div class="grid-container">
		<div id="app">
			<router-view></router-view>	
		</div>
		<template id="post-list-template">
			<div class="ref-heading-area">
				<div class="grid-x">
					<div class="cell large-6">
						<h1 class="triangle-title" data-aos="fade-up"><?php _e('NOS RÉFÉRENCES', 'berger');?></h1>
					</div>
					<div class="cell large-6">
               			<div class="ref-taxonomies" data-aos="fade-up">
						   	<span class="tax-num"><?php _e('TOUT', 'berger');?> ({{ terms.length }})</span>
							<select v-model="categoryFilter" @input="Filterterm($event.target.value, 1)">
								<option value=""><?php _e('FILTRER', 'berger');?></option>
								<option v-for="term in terms" value="{{ term.id }}">{{ term.name }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="ref-listing-area">
				<div class="grid-x">
					<div class="cell large-6 ref-slide" data-aos="fade-up" v-for="post in posts | filterBy categoryFilter in 'type_de_batiment'">
						<div class="ref-slide-image">
							<a href="{{ post.link }}">
								<img class="hover-img" src="<?php echo $theme_path;?>/assets/images/hover-img.svg" alt="hover-img">
								<div v-if="post.acf.post_listing_image.url">
									<img src="{{ post.acf.post_listing_image.url }}">
								</div>
								<div v-else>
									<img src="<?php echo $theme_path; ?>/assets/images/placeholder.png">
								</div>
							</a>
						</div>
						<div class="ref-sld-details">
							<div class="post-title">
								<a href="{{ post.link }}">{{ post.title.rendered }}</a>
							</div>
							<div class="post-taxonomy">
								<ul>
									<li v-for="category in post.reference_term">
										<a href="{{ post.reference_term_link }}" >{{ category.name }}</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="pagination">
					<span v-if="prev_page">
						<button class="page-numbers prev" v-on:click="getPosts(prev_page)" :disabled="!prev_page">
							<img src="<?php echo $theme_path;?>/assets/images/arrow-left.svg">
						</button>
					</span>
					<span v-if="prev_page">
						<button class="page-numbers" v-on:click="getPosts(prev_page)" :disabled="!prev_page">
							{{ prev_page }}
						</button>
					</span>
					<button class="page-numbers current" v-on:click="getPosts(prev_page)" :disabled="currentPage">
						{{ currentPage }}
					</button>
					<span v-if="next_page">
						<button class="page-numbers" v-on:click="getPosts(next_page)" :disabled="!next_page">
							{{ next_page }}
						</button>
					</span>
					<span v-if="next_page">
						<button class="page-numbers next" v-on:click="getPosts(next_page)" :disabled="!next_page">
							<img src="<?php echo $theme_path;?>/assets/images/arrow-right.svg">
						</button>
					</span>
				</div>
			</div>
		</template>
	</div>
</section>
<?php
get_footer();
