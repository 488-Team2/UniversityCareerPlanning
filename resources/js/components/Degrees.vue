<template>
    <div id= "degress">
     <br>

    <FlashMessage :position="'right top'"></FlashMessage>
    <h2>Degrees</h2>

        <div class="float-end">
            <a href="/sessions">
                    <button class="btn btn-primary"> Go to Session ( {{ count }} )</button>
                </a>
        </div>
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

        <transition-group name="slide-fade" tag="div" class="row row-cols-1">
        <!-- <div id="grow" class="card card-body mb-2" v-for="degree in degrees" v-bind:key="degree.id"> -->
        <div id="grow" class="card card-body mb-2" v-for="degree in degrees" v-bind:key="degree.id">
            <a class="degree" :href="'/degree/' + degree.id" >
                <h3> {{degree.degree_name}} </h3> 
                <p> {{degree.degree_description}} </p>                
            </a>      

            <div class="btn-toolbar" >
                <button type="button" class="btn btn-outline-primary float-end" @click="addSession(degree)"> Save To Session </button>
                &nbsp;
            </div> 
        </div>
         </transition-group>
    </div>


</template>

<script>
    export default {
    props: {
        keywords: {
            type: String
        },
        ids: {
          type: String
        }
    },
    data: function() {
        return {
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

            sessions: [],
            session: {
                id: '',
                session_id: '',
                name: '',
                description : '',
                graduation_rate: '',
                job_demand: '',
                job_prospects: ''
            },
            count: '0',
            boxOne: '',
        }
    },
    created() {
        this.constructURL();
        this.fetchDegrees();
        this.viewSession();
    },
    methods: {
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
        viewSession() {
            if(localStorage.getItem('sessions')) {
                this.sessions = JSON.parse(localStorage.getItem('sessions'));
                this.count = this.sessions.length;
            }
        },
        addSession(deg) {

            var found = this.sessions.find(p => p.session_id === deg.id);
            if(found) {
                //alert(deg.degree_name+' is already saved!');
                this.flashMessage.show({
							status: 'error',
                            message: deg.degree_name + " is already saved!",
                            time: 1000
				});
            } else {
                this.session.session_id =  deg.id;
                this.session.name = deg.degree_name;
                this.session.description = deg.degree_description;
                this.session.graduation_rate = deg.graduation_rate;
                this.session.job_demand = deg.job_demand;

                this.sessions.push(this.session);
               // alert(deg.degree_name+' saved!');
                this.flashMessage.show({
							status: 'success',
                            message: deg.degree_name + " saved!",
                            time: 1000
						});
                this.session.id =  this.sessions.length;

                this.session= {};
                this.storeSession();
            }
        },
        storeSession() {
             //this.axios.post('http://localhost:8000/api/degree/session', this.sessions)
             let parsed = JSON.stringify(this.sessions);
             localStorage.setItem('sessions', parsed);
             this.viewSession();
        }, 
        removeSession(deg) {
            this.sessions.splice(deg, 1);
            this.storeSession();
        }

    }
}
</script>

<style scoped>

.degree, .degree:hover{
    color: black;
    text-decoration: none;
}

#grow { 
    transition: all .2s ease-in-out; 
}
#grow:hover { 
    transform: scale(1.03); 
} 

#paginationNav {
    background: white;
}
.btn-toolbar {
    position: absolute;
    right: 20px; 
    top: 30px; 
    text-align: right;

}


</style>
