<template>
    <div>     
        <h1 class="text-center">  University Career Planning </h1>
        <p class="text-md-center">
        Explore our undergraduate, master's, doctoral, and certificate programs.
        Search your interests and we will match you with degrees
        </p>
        <div class="input-group mb-3">
            <input v-model="keywords" class="form-control mr-sm-2" placeholder="career or degree keywords">
            <a :href="'/degreeSearch/' + this.keywords">
                <button class="btn btn-outline-secondary my-2 my-sm-0" @ >Search</button>
            </a>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-outline-danger">SEARCH BY INTERESTS</button>
            <a href="/survey">
                <button type="button" class="btn btn-outline-danger">   TAKE SERVEY   </button>
            </a>
            <a href="/sessions">
                <button type="button" class="btn btn-outline-danger" v-if="currentUser !== null">  LOAD SAVED SESSION  </button>
            </a>
        </div>
        <br> 

        <h3 class="text-center">All available programs</h3>
        <div class="d-flex justify-content-center">
            <ul class="list-inline">
            <button @click.prevent="searchProgram('Undergraduate')" class="btn btn-outline-primary-sm">UNDERGRADUATE</button>
            <button @click.prevent="searchProgram('Graduate')" class="btn btn-outline-primary-sm">GRADUATE</button>
            <button @click.prevent="searchProgram('Minors')" class="btn btn-outline-primary-sm">MINORS</button>
            </ul> 
        </div>
<div v-if="showSearch==false"> 

        <transition-group name="slide-fade" tag="div" class="row row-cols-1 row-cols-md-3 g-4">
        <!-- <div class="row row-cols-1 row-cols-md-3 g-4" > -->
        <div class="col" v-for="degree in degrees" :key="degree.id" >
            <div class="card h-100 border-danger mb-3">
            <div id="grow" class="card-body" >
                 <a class="degree" :href="'/degree/' + degree.id" >
                    <h5 class="card-title"> {{degree.degree_name}} </h5>
                    <p class="card-text"> {{degree.degree_description }}</p>
                </a> 
            </div>
            </div> 
        </div>
        <!-- </div> -->
        </transition-group>

        <br>
        <nav id="paginationNav">
        <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" 
            class="page-item"><a class="page-link" href="#" 
            @click="fetchDegrees(pagination.prev_page_url)">Previous</a></li>

            <li class="page-item disabled"><a class="page-link dark-text"
             href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>


            <li v-bind:class="[{disabled: !pagination.next_page_url}]" 
            class="page-item"><a class="page-link" href="#"
             @click="fetchDegrees(pagination.next_page_url)">Next</a></li>
        </ul>
    </nav>
</div>
<div v-if="showSearch==true"> 
        <!--  <ul>
          <h4>Result(s): {{ searchArr.length }} </h4> 
          <li v-for="sear in searchArr" :key="sear.id"> {{sear.degree_name}} | name: {{sear.program_type}}</li>
        </ul> -->
         <transition-group name="slide-fade" tag="div" class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col" v-for="sear in searchArr" :key="sear.id" >
            <div class="card h-100 border-primary mb-3">
            <div id="grow" class="card-body" >
                 <a class="degree" :href="'/degree/' + sear.id" >
                    <h5 class="card-title"> {{sear.degree_name}} </h5>
                    <p class="card-text"> {{sear.degree_description }}</p>
                    <p class="card-text"> {{sear.program_type }}</p>
                </a> 
            </div>
            </div> 
        </div>
        </transition-group>
        <br>
        <br>
</div>
    </div>

    

</template>    

<script>
export default {
    keywords: "",
    name: "navbar",
    data() {
        return {
            currentUser: null,
            degrees: [],
            degree: {
                id: '',
                degree_name: '',
                degree_description: '',
                graduation_rate: '',
                job_demand: ''
            },
            degree_id: '', //how it will know which degree to update
            pagination: {},
            url: null,
            hover: false,
            search: '',
            showSearch: false,
			searchArr: [],
        }
    },
    async created() {
        await this.getCurrentUser();
        this.constructURL();
        this.fetchDegrees();
    },
    methods: {
        async getCurrentUser() {
            axios.get('/getCurrentUser')
                .then(response => {
                    this.currentUser = response.data
                })
                .catch(error => {
                    this.currentUser = null;
                    console.log(error)
                })
        },
        constructURL(){
            if(this.keywords != null){
                this.url = '/api/search/' + this.keywords;
            }
            else if(this.ids != null){
                this.url = '/api/degrees/' + this.ids;
            }
            else{
                this.url = '/api/degrees'
            }
        },
        fetchDegrees(page_url) {

            let vm = this;

            page_url = page_url || this.url
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.degrees = res.data;
                    vm.makePagination(res.meta, res.links)
                })
                .catch(err => console.log(err));
        },

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination;
        },
         searchProgram(q) {
               this.search=q
                fetch('/api/program/search?q=' + this.search)
				.then(res => res.json())
				.then(res => {
					this.searchArr = res;
					this.search = '';
					this.showSearch = true;
				})
				.catch(error => {
					console.log(error)
				});
               
     	
		}
    }
}
</script>

<style >

button {
    margin: 0 0.3rem;
}

nav {
    background-color: darkgray;
}
.nav-link {
    color: #fff;
}
/* .active {
  background: red;
} */

#grow { 
    transition: all .2s ease-in-out; 
}
#grow:hover { 
    transform: scale(1.03); 
    background: none;
}
.degree{
    color: black;
    text-decoration: none;
}
.degree:hover{
    color: steelblue;
}
#paginationNav {
    background: white;
}

.slide-fade-enter-active {
    transition: all .2s ease;
}

.slide-fade-leave-active {
    transition: all .6s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter,
.slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}

</style>
