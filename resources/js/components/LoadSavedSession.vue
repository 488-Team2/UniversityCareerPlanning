<template>
    <div>
        <button id="back-btn" class="btn btn-danger" onclick="history.back()">Back</button>

         <nav>
            <div class="nav nav-tabs bg-white" id="nav-tab" role="tablist">
                <button class=" nav-link active text-dark " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Degrees</button>
                <button class="nav-link text-dark" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Survey Result</button>
            </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                 <br>
                    <h4> Your saved degrees: {{ this.sessions.length }} </h4>
                         <div class="card card-body mb-2" v-for="session in sessions" :key="session.session_id">
                            <h4> {{ session.name }}</h4>
                            <p>  {{ session.description}} </p>
                            
                            <div class="btn-toolbar">
                                <a :href="'/degree/' + session.session_id" >
                                    <button class="btn btn btn-outline-primary"> Details</button>
                                </a>
                                &nbsp;
                                <button class="btn btn-outline-danger" @click="removeSession()"> Remove </button>
                            </div>
                        </div>

            </div>

            <div class="tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                 <br>
                    <h4> Your career survey result: {{ surveySessions.length}}</h4>
                    <div class="card card-body mb-2" v-for="res in this.surveySessions" :key="res.id">
                        <h3> {{ res.degree_name }}</h3>               
                    

                            <div class="btn-toolbar" >
                                <a :href="'/degree/' + res.id" >
                                    <button class="btn btn-outline-primary"> Details</button>
                                </a>
                                &nbsp;
                                <button class="btn btn-outline-danger" @click="removeSurveySession()"> Remove </button>
                            </div>

                    </div>
            </div>
            </div>


    </div>
</template>

<script>
export default {
    data() {
        return {
            sessions: [],
            session: {
                id: '',
                session_id: '',
                name: '',
                description : '',
                graduation_rate: '',
                job_demand: '',
                job_prospects: '',
            },
            isShowDegrees: true,
            isShowResult: true,
            surveySessions: []
        }
    },
    created() {
        this.viewSession();
        this.viewSurveySession();
    },
    methods: {
        viewSession() {
            if(localStorage.getItem('sessions')) {
                this.sessions = JSON.parse(localStorage.getItem('sessions'));
                
            }
        },storeSession() {
             //this.axios.post('http://localhost:8000/api/degree/session', this.sessions)
             let parsed = JSON.stringify(this.sessions);
             localStorage.setItem('sessions', parsed);
             this.viewSession();
        }, 
        removeSession(deg) {
            if(confirm("Do you really want to delete this session?")){
                this.sessions.splice(deg, 1);
                this.storeSession();
            }
        },
        viewSurveySession() {
            if(localStorage.getItem('surveySessions')) {
                this.surveySessions = JSON.parse(localStorage.getItem('surveySessions'));
                this.count = this.surveySessions.length;
            }
        },
        storeSurveySession() {
             let parsed = JSON.stringify(this.surveySessions);
             localStorage.setItem('surveySessions', parsed);
             this.viewSurveySession();
        },
        removeSurveySession() {
            this.surveySessions.splice(res, 1);
            this.storeSurveySession();
        }

    }
}
</script>
<style >
.divider{
    width:5px;
    height:auto;
    display:inline-block;
}

.btn-toolbar {
    position: absolute;
    right: 20px; 
    top: 20px; 
    text-align: right;

}
#back-btn {
    position: absolute;
    right: 85px; 
    top: 80px; 
    text-align: right;
}
</style>