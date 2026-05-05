
var catid =  jQuery("div #app").attr('data-id');  

var App = Vue.extend({});

var postList = Vue.extend({
    template:'#post-list-template',
    data: function(){
        return {
            posts: '',           
            categoryId: '',
            project_category: '',                                    
            post:'',
            show: false,
            allPages: '',
            prev_page: '',
            next_page: '',
            currentPage: ''
        }
    },

    ready: function(){
        
        project_category = this.$resource('/demogatsby/wp-json/wp/v2/project_category');
        project_category.get(function(project_category){
            this.$set('project_category', project_category);
        })

        this.getPosts(1);
    },

    methods: {

        getPosts: function(pageNumber){
            posts = '/demogatsby/wp-json/wp/v2/project?per_page=3&page=' + pageNumber + '&project_category='+ catid;

            this.currentPage = pageNumber;

            this.$http.get(posts).then(function(response){
                this.$set('posts', response.data);
                this.makePagination(response);
            });
        },

        makePagination: function(data){
            this.$set('allPages', data.headers('X-WP-TotalPages'));

            //Setup prev page
            if(this.currentPage > 1){
                this.$set('prev_page', this.currentPage - 1);
            } else {
                this.$set('prev_page', null);
            }

            // Setup next page
            if(this.currentPage == this.allPages){
                this.$set('next_page', null);
            } else {
                this.$set('next_page', this.currentPage + 1);
            }
            

        },
        
    }
})


var singlePost = Vue.extend({
    template: '#single-post-template',

    route:{
        data: function(){
            this.$http.get('/demogatsby/wp-json/wp/v2/project/' + this.$route.params.postID, function(post){
                this.$set('post', post);
            })
        }
    }

});

var router = new VueRouter();

router.map({
    '/':{
        component: postList
    },
    'post/:postID':{
        name:'post',
        component: singlePost
    },   
});

router.start(App, '#app');