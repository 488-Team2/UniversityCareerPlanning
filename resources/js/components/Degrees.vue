<template>
    <div>
    <h2>Degrees</h2>
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

        <div id="grow" class="card card-body mb-2" v-for="degree in degrees" v-bind:key="degree.id">
            <a class="degree" :href="'/degree/' + degree.id" >
                <h3> {{degree.degree_name}} </h3>
                <p> {{degree.degree_description}} </p>
            </a>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

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
            pagination: {},
            url: null,

        }
    },
    created() {
        this.constructURL();
        this.fetchDegrees();
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
        async fetchDegrees(page_url) {

            page_url = page_url || this.url 

            try{
                const response = await axios.get(page_url);
                this.degrees = response.data.data;
                this.makePagination(response.data.meta, response.data.links)
            } catch (error) {
                console.error(error);
            }
            
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

#paginationNav {
    background: white;
}



</style>

