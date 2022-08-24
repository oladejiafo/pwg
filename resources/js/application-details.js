import './bootstrap';
import Vue from 'vue'
import axios from 'axios'

window.Vue = require('vue').default;

const app = new Vue({
    el: '#app',
    data() {
        return {
            jobCategories: [],
            selectedJob: [],
        }
    },
    methods: {
        getCategories() { 
            axios
            .post('https://bo.pwggroup.ae/api/get-job-category-list')
            .then(function (response) {
                app.jobCategories = response.data;
                console.log(app.jobCategories);
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        addExperience(cat1, cat2, cat3, cat4, jobTitle) {
            console.log(cat1, cat2, cat3, cat4, jobTitle);
        }
    },
    mounted: function() {
        this.getCategories();
    }
});