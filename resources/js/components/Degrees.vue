<template>
    <div>
    <h2>Degrees</h2>
    <nav aria-label="Page navigation example">
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

        <div id="grow" class="card card-body mb-2" v-for="degree in degrees" v-bind:key="degree.id">
            <a class="degree" :href="'degree/' + degree.id" >
                <h3> {{degree.degree_name}} </h3>
                <p> {{degree.degree_description}} </p>
            </a>
        </div>
    </div>
</template>

<script>

export default{
    data() {
        return {
            degrees: [],
            degree: {
                id: '',
                degree_name: '',
                degree_description: '',
                department_id: '',
                graduation_rate: '',
                job_demand: ''
            },
            degree_id: '', //how it will know which degree to update
            pagination: {},
            edit: false
        }
    },

    created() {
        this.fetchDegrees();
    },
    methods: {
        fetchDegrees(page_url) {
            const url = window.location.href;
            var ids = url.split("/").slice(-1)[0]; // gets the ids from the url
            ids == 'degrees' ? ids = "" : ids = "/" + ids;

            let vm = this;

            page_url = page_url || '/api/degrees' + ids;
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
        }

    }
}

</script>

<style>

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

</style>