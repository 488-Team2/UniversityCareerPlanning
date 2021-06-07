<template>
    <div id="degress">

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
                                                  href="#">Page {{ pagination.current_page }} of {{
                        pagination.last_page
                    }}</a></li>


                <li v-bind:class="[{disabled: !pagination.next_page_url}]"
                    class="page-item"><a class="page-link" href="#"
                                         @click="fetchDegrees(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>

        <transition-group name="slide-fade" tag="div" class="row row-cols-1">
            <!-- <div id="grow" class="card card-body mb-2" v-for="degree in degrees" v-bind:key="degree.id"> -->
            <div id="grow" class="card card-body mb-2" v-for="degree in degrees" v-bind:key="degree.id">
                <a class="degree" :href="'/degree/' + degree.id">
                    <h3> {{ degree.degree_name }} </h3>
                    <p v-if="degree.degree_description != null && degree.degree_description.length<240">
                        {{ degree.degree_description }} </p>
                    <p v-else-if="degree.degree_description === null"></p>
                    <p v-else> {{ degree.degree_description.substring(0, 240) + "..." }} </p>

                </a>

                <div class="btn-toolbar">
                    <button type="button" class="btn btn-outline-primary float-end" @click="addSession(degree)"> Save To
                        Session
                    </button>
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
    data: function () {
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
                description: '',
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
        constructURL() {
            if (this.keywords != null) {
                this.url = '/api/search/' + this.keywords;
            } else if (this.ids != null) {
                this.url = '/api/degrees/' + this.ids;
            } else {
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
            if (localStorage.getItem('sessions')) {
                this.sessions = JSON.parse(localStorage.getItem('sessions'));
                this.count = this.sessions.length;
            }
        },
        addSession(deg) {

            var found = this.sessions.find(p => p.session_id === deg.id);
            if (found) {
                //alert(deg.degree_name+' is already saved!');
                this.flashMessage.show({
                    status: 'error',
                    message: deg.degree_name + " is already saved!",
                    time: 1000
                });
            } else {
                this.session.session_id = deg.id;
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
                this.session.id = this.sessions.length;

                this.session = {};
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

.degree {
    color: white;
    text-decoration: none;
    padding: 0;
	margin: 50px auto;
	list-style: none;
	text-align: center;
}
.card-body{
    font-color: white;
    display: inline-block;
	width: 20%;
	min-width: 200px;
	max-width: 230px;
	padding: 80px 20px 40px;
	position: relative;
	vertical-align: top;
	margin: 10px;
	font-family: 'helvetica', san-serif;
	min-height: 25vh;
	background: #262a2b;
	border: 1px solid #252727;
	text-align: left;
}

.card-body h3{
    font-color: white;
    font-size: 25px;
	margin: 0;
	position: absolute;
	top: 50px;
	right: 10px;
	transition: all 0.3s ease-in-out;
}
#grow {
    transition: all .2s ease-in-out;
}
#grow:hover { 
    transform: scale(1.03); 
} 

#paginationNav {
    background: gray;
    border-color: black;
}
.btn-toolbar {

    background: #222 url(/images/alert-overlay.png) repeat-x;
    background-color: gray;
    display: inline-block;
    padding: 5px 10px 6px;
    color: #fff;
    border-color: black;
    text-decoration: none;
    font-weight: bold;
    line-height: 1;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-box-shadow: 0 1px 3px #999;
    -webkit-box-shadow: 0 1px 3px #999;
    text-shadow: 0 -1px 1px #222;
    border-bottom: 1px solid #222;
    position: relative;
    cursor: pointer;
}
.btn-primary{
    background-color:gray;
    border-color:black;
}
.btn-outline-primary{
    background: #222 url(/images/alert-overlay.png) repeat-x;
    background-color: gray;
    display: inline-block;
    padding: 5px 10px 6px;
    color: #fff;
    border-color: black;
    text-decoration: none;
    font-weight: bold;
    line-height: 1;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-box-shadow: 0 1px 3px #999;
    -webkit-box-shadow: 0 1px 3px #999;
    text-shadow: 0 -1px 1px #222;
    border-bottom: 1px solid #222;
    position: relative;
    cursor: pointer;

}

.btn-primary:hover{
    background-color: #990000;
     transform: translateY(-10px);
}
.btn-outline-primary:hover{
    background-color: #990000;
}
.btn-toolbar:hover{
    background-color: #990000;
     transform: translateY(-10px);
}


</style>
