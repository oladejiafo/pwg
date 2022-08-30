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
            search: null,
            filterData: [],
            applicantId: null,
        }
    },
    methods: {
        getCategories() { 
            axios
            .post('https://bo.pwggroup.ae/api/get-job-category-list')
            .then(function (response) {
                app.jobCategories = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        addExperience(cat1, cat2, cat3, cat4, jobTitle) {
            // this.selectedJob.push({ name: jobTitle, cat1: cat1, cat2: cat2, cat3: cat3, cat4: cat4});
            axios.post('/add/experience', {
                applicant_id: this.applicantId,
                job_category_one_id : cat1,
                job_category_two_id : cat2,
                job_category_three_id : cat3,
                job_category_four_id : cat4,
                job_title: jobTitle
            }).then(function (response) {
                if(response){
                    app.getSelectedExperience();
                } else {
                    console.log('not here');
                    alert('You have to complete Payment first');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        removeJob(expId) {
            axios
            .post('/remove/selected/experience',{
                expId : expId,
                applicantId : this.applicantId
            })
            .then(function(response){
                app.getSelectedExperience();
            })
        },

        getSelectedExperience() {
            this.applicantId = this.$el.getAttribute('data-applicantId');
            axios
            .post('/get/selected/experience',{
                applicantId : this.applicantId
            })
            .then(function(response){
                if(response.data.length > 0) {
                    app.selectedJob = response.data;
                }
                console.log(app.selectedJob);
            })

        },

        filterJob() {
            if(this.search){
                axios
                .post('https://bo.pwggroup.ae/api/get-job-category-four-list',{
                    filter: this.search
                })
                .then(function (response) {
                    app.filterData = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else {
                app.filterData = [];
                this.getCategories();
            }
           
        }, 
    },
    mounted: function() {
        this.getCategories();
        this.getSelectedExperience();
        this.applicantId = this.$el.getAttribute('data-applicantId');
        console.log(this.applicantId);
    }
});