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
            selectedJobTitle: [],
            dependentId:null,
            dependentJob: [],
            dependentJobTitle: [],
        }
    },
    methods: {
        getCategories() { 
            axios
            .post('/get/job/category/list')
            .then(function (response) {
                app.jobCategories = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        addExperience(cat1, cat2, cat3, cat4, jobTitle, userType) {
            this.dependentId = this.$el.getAttribute('data-dependentId');
            axios.post('/add/experience', {
                applicant_id: this.applicantId,
                job_category_one_id : cat1,
                job_category_two_id : cat2,
                job_category_three_id : cat3,
                job_category_four_id : cat4,
                job_title: jobTitle,
                userType: userType,
                dependentId: app.dependentId
            }).then(function (response) {
                if(response){
                    toastr.success('Experience Added Successfully !');
                    app.getSelectedExperience();
                    app.getDependentExperience();
                } else {
                    alert('You have to complete Payment first');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        removeJob(expId, userType) {
            axios
            .post('/remove/selected/experience',{
                expId : expId,
                userType : userType, 
                dependentId: app.dependentId
            })
            .then(function(response){
                toastr.success('Experience Removed Successfully !');
                app.getSelectedExperience();
                app.getDependentExperience();
            })
        },

        getSelectedExperience() {
            this.applicantId = this.$el.getAttribute('data-applicantId');
            axios
            .post('/get/selected/experience')
            .then(function(response){
                if(response.data.length > 0) {
                    app.selectedJob = response.data;
                    for(var i = 0; i < app.selectedJob.length ; i++ ){
                        var jobTitle = app.selectedJob[i].job_title;
                        app.selectedJobTitle.push(jobTitle);
                    }
                } else {
                    app.selectedJob = [];
                    app.selectedJobTitle = [];
                }
                
            });

        },

        getDependentExperience(){
            this.applicantId = this.$el.getAttribute('data-applicantId');
            this.dependentId =  this.$el.getAttribute('data-dependentId');
            axios
            .post('/get/dependent/selected/experience',{
                dependentId : this.dependentId 
            })
            .then(function(response){
                if(response.data.length > 0) {
                    app.dependentJob = response.data;
                    for(var i = 0; i < app.dependentJob.length ; i++ ){
                        var dependentTitle = app.dependentJob[i].job_title;
                        app.dependentJobTitle.push(dependentTitle);
                    }
                } else {
                    app.dependentJob = [];
                    app.dependentJobTitle = [];
                }
            })
        },

        filterJob() {
            if(this.search){
                axios
                .post('/get/job/category/four/list',{
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
        this.getDependentExperience();
        this.applicantId = this.$el.getAttribute('data-applicantId');
        this.dependentId = this.$el.getAttribute('data-dependentId');
    }
});

