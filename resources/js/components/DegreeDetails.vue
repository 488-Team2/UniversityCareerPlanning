<template>
    <div>
       <h2 class="mt-3">{{degree.degree_name}}</h2>
       <p>{{degree.degree_description}}</p>
       <div id="stats">
        <scale class="mb-4" :rate='degree.graduation_rate' :name="'Graduation Rate'"></scale>
        <scale class="mb-4" :rate='degree.job_demand' :name="'Job Demand'"></scale>
       </div>
    </div>
</template>

<script>

export default{
    data() {
        return {
            degree: {
                id: '',
                degree_name: '',
                degree_description: '',
                department_id: '',
                graduation_rate: '',
                job_demand: ''
            },
            edit: false
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
        }
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
