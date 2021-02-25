<template>
    <div>
        <p>This is the survey grader</p>
        <ul>
            <li v-for="response in responses">
                {{ response }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SurveyGrader",
    props: {
        responses: Object
    },
    created() {

    },
    methods: {}
}
</script>

<style scoped>

</style>
