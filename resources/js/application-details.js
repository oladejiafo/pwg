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

        addExperience(cat1, cat2, cat3, cat4, jobTitle, applicantId) {
            this.selectedJob.push({ name: jobTitle, cat1: cat1, cat2: cat2, cat3: cat3, cat4: cat4});
            // axios.post('/add/experience', {
            //     applicant_id: applicantId,
            //     job_category_one_id : cat1,
            //     job_category_two_id : cat2,
            //     job_category_three_id : cat3,
            //     job_category_four_id : cat4
            // }).then(function (response) {
               
            //     console.log(response);
            // })
            // .catch(function (error) {
            //     console.log(error);
            // });
        },

        removeJob(index) {
            this.selectedJob.splice(index, 1);
        },

        getSelectedExperience() {
            
        }
    },
    mounted: function() {
        this.getCategories();
        this.getSelectedExperience();
    }
});