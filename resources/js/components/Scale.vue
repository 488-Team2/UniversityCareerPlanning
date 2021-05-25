<template>
    <div>
        <h5>{{name}}</h5>
        <div :style="calcLocation">{{rate}}%</div>
        <div id="container">
    
            <div class="position" :style="calcRate"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        rate: {
            type: Number
        },
        name: {
            type: String
        },
        max: {
            type: Number
        },
        min: {
            type: Number
        }
    },
    computed: {
        calcRate() {
            console.log((100 / this.range) * this.min * -1 + (this.rate * (100 / this.range)));
            return {
                "background-color": `#2A2A2A`,
                width: `2%`,
                "margin-left": `${(100/this.range)*this.min*-1+(this.rate*(100/this.range))}%`
            };
        },
        calcLocation() {
            return {
                "margin-left": `${(100/this.range)*this.min*-1+(this.rate*(100/this.range))}%`
            };
        },
        range() {
          return (this.max - this.min)
        }
    }
}
</script>

<style>

#container {
    width: 100%;
    /* Full width */
    background-image: linear-gradient(to right, red, yellow, green);
    border-radius: 25px;
}

.position {
    text-align: right;
    padding-top: 10px;
    padding-bottom: 10px;
    color: white;
}
</style>