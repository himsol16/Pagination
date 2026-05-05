var App = Vue.extend({});
var postList = Vue.extend({

    template:"#post-list-template",
    data: function(){
        return{
            posts:'',
            categoryFilter:'',
            terms:'',
            allPages:'',
            prev_page: '',
            next_page: '',
            currentPage: '',
        }
    },
    ready: function(){
        terms = this.$resource('/wp-json/wp/v2/type_de_batiment?hide_empty=true');
        terms.get(function(terms){
            this.$set('terms', terms);
        })
        this.getPosts(1);
    },
    methods: {
        getPosts: function(pageNumber){
            var termele = document.getElementById("post-term-selector");
            if (termele == null) {

                posts = "/wp-json/wp/v2/reference?per_page=8&page=" + pageNumber + "&acf_format=standard";

            }
            else
            {
                var termid = termele.value;
                posts = "/wp-json/wp/v2/reference?type_de_batiment="+ termid +"&per_page=8&page=" + pageNumber + "&acf_format=standard";
            }
            this.currentPage = pageNumber;
            this.$http.get(posts).then(function(response){
                console.log(response);
                this.$set('posts', response.data);
                this.makePagination(response);
            });
            this.scrollToTop();
        },
        Filterterm: function(termid, pageNumber){

            if (termid == '') {
                posts = "/wp-json/wp/v2/reference?per_page=8&page=" + pageNumber + "&acf_format=standard";
            }
            else
            {
                posts = "/wp-json/wp/v2/reference?type_de_batiment="+ termid +"&per_page=8&page=" + pageNumber + "&acf_format=standard";
            }

            this.currentPage = pageNumber;
            this.$http.get(posts).then(function(response){
                console.log(response);
                console.log('filter response');
                this.$set('posts', response.data);
                this.makePagination(response);
            });
        },
        makePagination: function(data){
            this.$set('allPages', data.headers('X-Wp-Totalpages'));
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
        scrollToTop() {
          window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
        }
    }
});
var router = new VueRouter();
router.map({
    '/':{
        component: postList
    } 
})
router.start(App, '#app');