
<div class="row">
    <div class="collapse" id="collapseExperience"  data-applicantId="<?php echo e($applicant['id']); ?>" data-dependentId="<?php echo e($dependent); ?>">
        <div class="form-sec">
            <div class="jobSelected">
                <table class="table" v-if="selectedJob.length > 0">
                    <thead>
                        <tr>
                            <td>Job Sector</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(job, jobIndex) in selectedJob">
                            <td style="text-align: left;" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id" aria-expanded="false" :aria-controls="'collapseExperienceFour'+job.job_category_one_id+job.job_category_two_id+job.job_category_three_id+job.job_category_four_id">{{job.job_title}}</td>
                            <td style="text-align: right;"><a class="btn btn-danger remove" v-on:click="removeJob(job.id, 'applicant')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h4 style="margin-top:60px">Job Sector List</h4>
            <p style="display:flex;color:white; padding:2%;background-color: rgb(67, 65, 65); height: 100px; float:left; font-weight:400"> <span><i class="fa fa-info-circle fa-spin-pulse fa-rotate-90" style="display:inline-block;font-size:55px;font-style:italics;color:#FAE008; margin-left:5px; margin-right:15px;--fa-animation-duration: 5s;"></i></span> <span style="display:inline-block">You can add your experience by expanding below options to select your experience that is relevant to this application, or search on using the search bar. Please know that you can add more than one experience and remove it if you no longer want it to appear.<span></p>
            <div class="form-group mt-4 searchForm">
                <div class="row">
                    <div class="col-8 col-md-10 col-lg-10 mt-3" >
                        <input type="text" class="form-control" v-model="search" name="search" placeholder="Enter Job Title" >
                    </div>
                    <div class="col-4 col-md-2 col-lg-2 mt-3" style="padding-left: 0px">
                        <button class="btn btn-danger expSearch" v-on:click="filterJob()">Search</button>
                    </div>
                </div>
            </div>
            <div v-if="filterData.length > 0">
                <div  v-for='(data, index) in filterData' class="filterData" >
                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseExperience'+data.id">
                        <div class="row">
                            <div class="col-10">
                                <p class="exp-font">{{data.name}}</p>
                            </div>
                            <div class="col-1 mx-auto my-auto">
                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+data.id" aria-expanded="false" :aria-controls="'collapseExperience'+data.id">
                                    <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" :id="'collapseExperience'+data.id">
                        <div class="detail-sec">
                            <div class="row">
                                <h5>Description</h5>
                                <p v-html="data.description"></p>
                            </div>
                            <div class="row">
                                <h5>Example Titles</h5>
                                <p>{{data.example_titles}}</p>
                            </div>
                            <div class="row">
                                <h5>Main Duties</h5>
                                <p >
                                    <span style="white-space: pre-line">{{data.main_duties}}</span>
                                </p>
                            </div>
                            <div class="row">
                                <h5>Employement Requirment</h5>
                                <p >
                                    <span style="white-space: pre-line">{{data.employement_requirements}}</span>
                                </p>
                            </div>
                            <div class="form-group row mt-4" style="margin-bottom: 20px">
                                <div class="row">
                                    <button type="button" v-if="selectedJobTitle.includes(data.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                    <button type="button" v-else class="btn btn-primary submitBtn" applicantId="<?php echo e($applicant['id']); ?>" v-on:click="addExperience(null,null,data.job_category_three_id,data.id,data.name,'applicant')" style="line-height: 22px">Add Experience</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div v-else-if="jobCategories.length > 0" >
                <div v-for='(jobCategoryOne, index) in jobCategories' class="jobCategory">
                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+index" aria-expanded="false" :aria-controls="'collapseExperience'+index">
                        <div class="row">
                            <div class="col-10">
                                <p class="exp-font">{{jobCategoryOne.name}}</p>
                            </div>
                            <div class="col-1 mx-auto my-auto">
                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperience'+index" aria-expanded="false" :aria-controls="'collapseExperience'+index">
                                    <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" :id="'collapseExperience'+index" style="width: 95%; margin-left:2%">
                        <div class="jobCategoryTwo"  v-for='(jobCategoryTwo, indexTwo) in jobCategoryOne.job_category_two'>
                            <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseExperienceTwo'+index+indexTwo">
                                <div class="row">
                                    <div class="col-10">
                                        <p class="exp-font">{{jobCategoryTwo.name}}</p>
                                    </div>
                                    <div class="col-1 mx-auto my-auto">
                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceTwo'+index+indexTwo" aria-expanded="false" :aria-controls="'collapseExperienceTwo'+index+indexTwo">
                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" :id="'collapseExperienceTwo'+index+indexTwo" style="width: 95%; margin-left:2%">
                                <div class="jobCategoryThree" v-for='(jobCategoryThree, indexThree) in jobCategoryTwo.job_category_three'>
                                    <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseExperienceThree'+index+indexTwo+indexThree">
                                        <div class="row">
                                            <div class="col-10">
                                                <p class="exp-font">{{jobCategoryThree.name}}</p>
                                            </div>
                                            <div class="col-1 mx-auto my-auto">
                                                <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceThree'+index+indexTwo+indexThree" aria-expanded="false" :aria-controls="'collapseExperienceThree'+index+indexTwo+indexThree">
                                                    <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" :id="'collapseExperienceThree'+index+indexTwo+indexThree" style="width: 95%; margin-left:2%">
                                        <div class="jobCategoryThree" v-for='(jobCategoryFour, indexFour) in jobCategoryThree.job_category_four'>
                                            <div class="experience-sec" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="exp-font">{{jobCategoryFour.name}}</p>
                                                    </div>
                                                    <div class="col-1 mx-auto my-auto">
                                                        <div class="down-arrow" data-bs-toggle="collapse" :data-bs-target="'#collapseExperienceFour'+index+indexTwo+indexThree+indexFour" aria-expanded="false" :aria-controls="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                            <img src="<?php echo e(asset('images/down_arrow.png')); ?>" height="auto" class="exp-image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse" :id="'collapseExperienceFour'+index+indexTwo+indexThree+indexFour">
                                                <div class="detail-sec">
                                                    <div class="row">
                                                        <h5>Description</h5>
                                                        <p v-html="jobCategoryFour.description"></p>
                                                    </div>
                                                    <div class="row">
                                                        <h5>Example Titles</h5>
                                                        <p>{{jobCategoryFour.example_titles}}</p>
                                                    </div>
                                                    <div class="row">
                                                        <h5>Main Duties</h5>
                                                        <p >
                                                            <span style="white-space: pre-line">{{jobCategoryFour.main_duties}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="row">
                                                        <h5>Employement Requirment</h5>
                                                        <p >
                                                            <span style="white-space: pre-line">{{jobCategoryFour.employement_requirements}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="form-group row mt-4" style="margin-bottom: 20px">
                                                        <div class="row">
                                                            <button type="button" v-if="selectedJobTitle.includes(jobCategoryFour.name)" class="btn btn-primary submitBtn" disabled  style="line-height: 22px">Added</button>
                                                            <button type="button" v-else class="btn btn-primary submitBtn" data-applicantId="<?php echo e($applicant['id']); ?>" v-on:click="addExperience(jobCategoryOne.id,jobCategoryTwo.id,jobCategoryThree.id,jobCategoryFour.id,jobCategoryFour.name,'applicant')" style="line-height: 22px">Add Experience</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row mt-4">
            <div class="col-lg-4 col-md-10 offset-lg-4 offset-md-1 col-sm-12">
                <?php if(($applicant['work_permit_category'])&&($client['is_spouse'] != null || $client['children_count'] != null)): ?> 
                    <button type="submit" class="btn btn-primary submitBtn applicantNext">  Next </button>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary submitBtn applicantReview">  Submit <i class="fa fa-spinner fa-spin applicantReviewSpin"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/user/experience.blade.php ENDPATH**/ ?>