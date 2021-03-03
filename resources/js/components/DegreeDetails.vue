<template>
    <div>
        <h2 class="mt-3">{{degree.degree_name}}</h2>
        <p>{{degree.degree_description}}</p>
        <div id="stats">
            <scale class="mb-4" :rate='degree.graduation_rate' :name="'Graduation Rate'"></scale>
            <scale class="mb-4" :rate='degree.job_demand' :name="'Job Demand'"></scale>
        </div class="mb-8">
            <h4 class="mt-4" >Job Prospects</h4>
            <li class="mb-2" v-for="job in degree.job_prospects.split(',')" :key="degree.id">
            {{job}}
            </li>
        <div>
         
        </div>

        <salary  class="mt-4" :jobArr="degree.job_prospects.split(', ')"></salary>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            degree: {
                id: '',
                degree_name: '',
                degree_description: '',
                department_id: '',
                graduation_rate: '',
                job_demand: '',
                job_prospects: '',
            },
            edit: false,
            value: ''
        }
    },

    created() {
        this.fetchDegree();
    },

    methods: {
        fetchDegree() {
            const url = window.location.href;
            const id = url.split("/").slice(-1)[0]; // gets the id from the url

            fetch('/api/degree/' + id)
                .then(res => res.json())
                .then(res => {
                    this.degree = res.data;
                })
                .catch(err => console.log(err));
        },
    },


}
</script>

<style>
#stats {
    padding: 20px;
    border-radius: 25px;
    background-color: #ECECEC;
    width: 50%;
}
</style>
