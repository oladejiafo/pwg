<?php echo $__env->make('user.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- bootstrap core css -->


<link rel="stylesheet" href="<?php echo e(asset('user/extra/css/bootstrap.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('user/extra/css/styled.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
<!--  -->
<link href="<?php echo e(asset('user/css/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    

<style>
    body {
        background: #f0f3f4 !important;
        /* #f0f3f4 */
        font-family: 'TT Norms Pro' !important;
    }

    hr {
        height: 1px;
        color: #e5e8e9 !important;
        background-color: #ccc;
        opacity: 1;
    }

    .cardx {
        width: 60%;
        margin: 0 auto;
        /* margin-right:25%;
    margin-left:15%; */
        margin-top: 150px;
    }

    .card {
        width: 100%;
        margin: 0 auto;

    }

    .card .ppanel-heading {
        height: 110px;
        margin-top: 2px;

    }

    .card .panel-title {
        margin-left: 50px;
        font-size: 48px;
        color: #ccc;
    }

    svg {
        width: 70px;
        margin-right:50px;
    }
    .nav-item .dropdown-menu-left {
         margin-left: -40px !important;   
         width:200px !important;
        }
       
        .nav-item .dropdown-menu-left button {
            width: 150px !important;
        }

      .nav-item img {
        display: inline !important;
      }
    @media (min-width: 375px) and (max-width: 768px) {

        svg {
            width:40px;
            margin-right:20px;
        }
        .card {
            width: 100%;
            margin: 0 auto;
            /* margin-right:25%;
    margin-left:15%; */
            margin-top: 60px;
        }
        .card .ppanel-heading {
            height: 70px;
       width: 100%;
            margin: 5px !important;
            padding: 10px !important;
        }
        .cardx {
            padding: 0;
            width: 100%;
            margin: auto;
        }

        .panel-title {
            margin-left: 0px !important;
            padding-left: 0px;
        }

        .navbar {
            width: 100% !important;
        }
        .navbar-toggler {
            width: 40px !important;
            height: 40px !important;
            padding: 4px !important;
            float: right !important;
        }
        .navbar-toggler .ini-menu {
            margin: auto !important;
            padding: 0px;
        }

        .ppanel-heading a::after {
            right: 20px;
            font-size: 40px;
            top: 35%;

        }
        .ppanel-heading a.collapsed:after {
            font-size: 40px;
            margin-top: -30px;
        }

        .panel-body {
            padding: 0px !important;
            margin: 0 !important;
        }

    }
</style>

<!-- Scripts -->
<script src="<?php echo e(asset('js/app.js')); ?>" defer></script>


 <?php $__env->slot('header', null, []); ?> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <?php echo e(__('User Profile')); ?>

    </h2>
 <?php $__env->endSlot(); ?>

<body>

    <div class="row cardx" style="border-radius:10px;">

        <div class="col-12 cardcx">
            <div class="about-desc animate-box">
                <div class="fancy-collapse-panel">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                        <!-- Tab One -->
                        <div class="panel panel-default card" style="border-radius: 10px;">
                            <div class="ppanel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">


                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="vertical-align: middle;">
                                        <span style="display:inline-block">

                                            <svg height="100%"  id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 109.62 109.62">
                                                <defs>
                                                    <style>
                                                        .cls-1 {
                                                            fill: #383838;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="cls-1" d="M0,86.91q21.95,0,43.88,0c.65,0,.85.16.84.83,0,1.79,0,1.8,1.84,1.8,5.78,0,11.56,0,17.34,0,.82,0,1.09-.18,1.05-1-.07-1.59,0-1.59,1.63-1.59q21,0,42,0c1,0,1.2.3,1,1.18a9.18,9.18,0,0,1-1.21,3.4,4.56,4.56,0,0,1-4,2.25h-.86q-48.58,0-97.18,0c-4,0-5.38-2.21-6.07-4.78,0-.19,0-.44-.24-.54Z" />
                                                <path class="cls-1" d="M42.75,67.81a23.45,23.45,0,0,1-6.89,1.28c-.46,0-.93.06-1.39.08l-.45.07c-.41,0-.83,0-1.25,0-.18,0-.43.09-.57-.06h-.27l.19-.18c0-.24.14-.44.3-.61.61-.69,1.27-1.34,1.95-2a1.42,1.42,0,0,0,.36-1.82c-.69-1.6-1.34-3.22-2-4.83a1.72,1.72,0,0,1,.12-2.1c-.69-.06-1.24,0-2-.11a1.44,1.44,0,0,1,.37,2c-.69,1.53-1.25,3.11-1.93,4.65s-.63,1.41.5,2.55c.56.56,1.13,1.09,1.65,1.68.16.19.37.39.29.65l.13.14h-.2c-.14.15-.39.06-.57.06-.42,0-.84,0-1.26,0l-.44-.07a31.64,31.64,0,0,1-7.49-1.07c-2.71-.81-3.24-1.74-2.13-4.35a12.9,12.9,0,0,1,7.42-6.83c.45-.19.93-.33,1.4-.49,0-.39-.37-.49-.59-.68-2.81-2.55-3.87-6.74-2.43-9.7a7.05,7.05,0,0,1,8.92-3.59,7.14,7.14,0,0,1,4.18,8.66,9.83,9.83,0,0,1-3.55,5.25,15.81,15.81,0,0,1,5,2.45,11.8,11.8,0,0,1,4.24,5.49C45,66.27,44.66,67.05,42.75,67.81Z" />
                                                <path class="cls-1" d="M69.83,72.79c0,1-.68,1.48-1.93,1.48q-9.42,0-18.84,0c-1.45,0-2.26-1.06-1.72-2.18A1.64,1.64,0,0,1,49,71.23H67.86C69.21,71.24,69.86,71.77,69.83,72.79Z" />
                                                <path class="cls-1" d="M90.43,64.08a1.42,1.42,0,0,1-1.27,1.59,6.31,6.31,0,0,1-1.07,0H49.46a4.72,4.72,0,0,1-1.06-.06,1.41,1.41,0,0,1-1.2-1.54,1.39,1.39,0,0,1,1.33-1.41,7.71,7.71,0,0,1,1,0H88.12c.32,0,.64,0,1,0A1.38,1.38,0,0,1,90.43,64.08Z" />
                                                <path class="cls-1" d="M90.43,55.51A1.38,1.38,0,0,1,89.38,57a3.08,3.08,0,0,1-1,.1H49.27A2.7,2.7,0,0,1,48.11,57a1.4,1.4,0,0,1-.9-1.54,1.34,1.34,0,0,1,1.2-1.3,7.77,7.77,0,0,1,1.18,0H88a9.15,9.15,0,0,1,1.17,0A1.37,1.37,0,0,1,90.43,55.51Z" />
                                                <path class="cls-1" d="M90.43,46.93a1.38,1.38,0,0,1-1.05,1.54,4,4,0,0,1-1.16.1H49.38a4.69,4.69,0,0,1-1.06-.07,1.49,1.49,0,0,1,.19-2.93c.35,0,.71,0,1.07,0H88a7.72,7.72,0,0,1,1.18,0A1.36,1.36,0,0,1,90.43,46.93Z" />
                                                <path class="cls-1" d="M100.71,23.16a7,7,0,0,0-7.3-7.27q-38.59,0-77.18,0C11.69,15.91,9,18.65,9,23.16,9,38,9,63,9,77.84a8.15,8.15,0,0,0,.16,2C10,83.17,12.48,85,16.17,85H54.7c12.89,0,25.77-.07,38.64,0a7,7,0,0,0,7.37-7.31C100.61,63,100.62,37.93,100.71,23.16ZM97.13,77.53c0,2.87-1.08,4-3.95,4H16.43c-2.86,0-3.93-1.08-3.93-4v-54c0-2.94,1.05-4,4-4H93.25c2.79,0,3.88,1.1,3.88,3.89Z" />
                                                <path class="cls-1" d="M69.83,72.79c0,1-.68,1.48-1.93,1.48q-9.42,0-18.84,0c-1.45,0-2.26-1.06-1.72-2.18A1.64,1.64,0,0,1,49,71.23H67.86C69.21,71.24,69.86,71.77,69.83,72.79Z" />
                                                <path class="cls-1" d="M90.43,64.08a1.42,1.42,0,0,1-1.27,1.59,6.31,6.31,0,0,1-1.07,0H49.46a4.72,4.72,0,0,1-1.06-.06,1.41,1.41,0,0,1-1.2-1.54,1.39,1.39,0,0,1,1.33-1.41,7.71,7.71,0,0,1,1,0H88.12c.32,0,.64,0,1,0A1.38,1.38,0,0,1,90.43,64.08Z" />
                                                <path class="cls-1" d="M90.43,55.51A1.38,1.38,0,0,1,89.38,57a3.08,3.08,0,0,1-1,.1H49.27A2.7,2.7,0,0,1,48.11,57a1.4,1.4,0,0,1-.9-1.54,1.34,1.34,0,0,1,1.2-1.3,7.77,7.77,0,0,1,1.18,0H88a9.15,9.15,0,0,1,1.17,0A1.37,1.37,0,0,1,90.43,55.51Z" />
                                                <path class="cls-1" d="M47.19,47a1.41,1.41,0,0,1,1.32-1.43c.35,0,.71,0,1.07,0H88a7.72,7.72,0,0,1,1.18,0,1.36,1.36,0,0,1,1.27,1.35,1.38,1.38,0,0,1-1.05,1.54,4,4,0,0,1-1.16.1H49.38a4.69,4.69,0,0,1-1.06-.07A1.4,1.4,0,0,1,47.19,47Z" />
                                                <path class="cls-1" d="M42.75,67.81a23.45,23.45,0,0,1-6.89,1.28c-.46,0-.93.06-1.39.08l-.45.07c-.41,0-.83,0-1.25,0-.18,0-.43.09-.57-.06a.23.23,0,0,1-.07-.14.06.06,0,0,1,0,0c0-.24.14-.44.3-.61.61-.69,1.27-1.34,1.95-2a1.42,1.42,0,0,0,.36-1.82c-.69-1.6-1.34-3.22-2-4.83a1.72,1.72,0,0,1,.12-2.1c-.69-.06-1.24,0-2-.11a1.44,1.44,0,0,1,.37,2c-.69,1.53-1.25,3.11-1.93,4.65s-.63,1.41.5,2.55c.56.56,1.13,1.09,1.65,1.68.16.19.37.39.29.65a.3.3,0,0,1-.07.14c-.14.15-.39.06-.57.06-.42,0-.84,0-1.26,0l-.44-.07a31.64,31.64,0,0,1-7.49-1.07c-2.71-.81-3.24-1.74-2.13-4.35a12.9,12.9,0,0,1,7.42-6.83c.45-.19.93-.33,1.4-.49,0-.39-.37-.49-.59-.68-2.81-2.55-3.87-6.74-2.43-9.7a7.05,7.05,0,0,1,8.92-3.59,7.14,7.14,0,0,1,4.18,8.66,9.83,9.83,0,0,1-3.55,5.25,15.81,15.81,0,0,1,5,2.45,11.8,11.8,0,0,1,4.24,5.49C45,66.27,44.66,67.05,42.75,67.81Z" />
                                                <path class="cls-1" d="M89.38,48.47a4,4,0,0,1-1.16.1H49.38a4.69,4.69,0,0,1-1.06-.07,1.49,1.49,0,0,1,.19-2.93c.35,0,.71,0,1.07,0H88a7.72,7.72,0,0,1,1.18,0,1.36,1.36,0,0,1,1.27,1.35A1.38,1.38,0,0,1,89.38,48.47Z" />
                                                <path class="cls-1" d="M89.38,38.8a4,4,0,0,1-1.16.11H49.38a4.18,4.18,0,0,1-1.06-.08,1.49,1.49,0,0,1,.19-2.93c.35,0,.71,0,1.07,0H88a9.25,9.25,0,0,1,1.18,0,1.36,1.36,0,0,1,1.27,1.35A1.38,1.38,0,0,1,89.38,38.8Z" />
                                                <path class="cls-1" d="M89.38,57a3.08,3.08,0,0,1-1,.1H49.27A2.7,2.7,0,0,1,48.11,57a1.4,1.4,0,0,1-.9-1.54,1.34,1.34,0,0,1,1.2-1.3,7.77,7.77,0,0,1,1.18,0H88a9.15,9.15,0,0,1,1.17,0,1.37,1.37,0,0,1,1.26,1.37A1.38,1.38,0,0,1,89.38,57Z" />
                                                <path class="cls-1" d="M90.43,64.08a1.42,1.42,0,0,1-1.27,1.59,6.31,6.31,0,0,1-1.07,0H49.46a4.72,4.72,0,0,1-1.06-.06,1.41,1.41,0,0,1-1.2-1.54,1.39,1.39,0,0,1,1.33-1.41,7.71,7.71,0,0,1,1,0H88.12c.32,0,.64,0,1,0A1.38,1.38,0,0,1,90.43,64.08Z" />
                                                <path class="cls-1" d="M69.83,72.79c0,1-.68,1.48-1.93,1.48q-9.42,0-18.84,0c-1.45,0-2.26-1.06-1.72-2.18A1.64,1.64,0,0,1,49,71.23H67.86C69.21,71.24,69.86,71.77,69.83,72.79Z" />
                                                <path class="cls-1" d="M88.25,28.26c0,1-.68,1.48-1.94,1.48q-9.41,0-18.83,0c-1.45,0-2.26-1.06-1.72-2.18a1.64,1.64,0,0,1,1.69-.86c3.14,0,6.28,0,9.42,0h9.41C87.63,26.71,88.28,27.23,88.25,28.26Z" />
                                            </svg>

                                            <!-- <img src="<?php echo e(asset('images/Icons_applicant_details.svg')); ?>" width="70px" height="auto" style="margin-right:50px"> -->
                                        </span>
                                        <span class="title" style="display:inline-block">
                                            |&nbsp; <?php echo e(__('Profile Information')); ?>

                                        </span>
                                    </a>
                                </h4>
                            </div>
                            <hr>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">

                                    <?php if(Laravel\Fortify\Features::canUpdateProfileInformation()): ?>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('profile.update-profile-information-form')->html();
} elseif ($_instance->childHasBeenRendered('8kTOQsg')) {
    $componentId = $_instance->getRenderedChildComponentId('8kTOQsg');
    $componentTag = $_instance->getRenderedChildComponentTagName('8kTOQsg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8kTOQsg');
} else {
    $response = \Livewire\Livewire::mount('profile.update-profile-information-form');
    $html = $response->html();
    $_instance->logRenderedChild('8kTOQsg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.section-border','data' => []]); ?>
<?php $component->withName('jet-section-border'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <p style="margin-top: 5px;"> &nbsp; </p>

                        <!-- Tab Two -->
                        <div class="panel panel-default card" style="border-radius: 10px;margin-top:1px">
                            <div class="ppanel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">

                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="vertical-align: middle;">
                                        <span style="display:inline-block">

                                            <svg  height="100%" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 109.02 109.04">
                                                <defs>
                                                    <style>
                                                        .cls-1 {
                                                            fill: #383838;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="cls-1" d="M29.16,47.22c-.92,0-1.84,0-2.76,0h0c-.85,0-1.7,0-2.55,0a1.75,1.75,0,0,0-2,1.79c-.06,1.81-.06,3.62,0,5.42a1.8,1.8,0,1,0,3.59,0c.05-1,.05-1.92,0-2.87,0-.54.13-.75.71-.73,1,0,2,0,3,0A1.8,1.8,0,0,0,31,49,1.76,1.76,0,0,0,29.16,47.22Zm0,0c-.92,0-1.84,0-2.76,0h0c-.85,0-1.7,0-2.55,0a1.75,1.75,0,0,0-2,1.79c-.06,1.81-.06,3.62,0,5.42a1.8,1.8,0,1,0,3.59,0c.05-1,.05-1.92,0-2.87,0-.54.13-.75.71-.73,1,0,2,0,3,0A1.8,1.8,0,0,0,31,49,1.76,1.76,0,0,0,29.16,47.22Zm79.24,15a5.45,5.45,0,0,0-4.53-2.55c-2.55,0-5.1,0-7.65,0-1.31,0-1.37-.06-1.37-1.39,0-3,0-6,0-9a9.44,9.44,0,0,0-8-9.48c-1-.16-1.19-.58-1.18-1.46,0-2.47,0-5,0-7.44a23,23,0,0,0-.29-4.23C83.53,15,77.15,6.8,66.37,2a24.47,24.47,0,0,0-8.83-2H51.37c-1.24.26-2.53.15-3.77.46A31.33,31.33,0,0,0,23.4,31c0,2.44,0,4.89,0,7.33,0,.84-.2,1.31-1.14,1.4a7.43,7.43,0,0,0-3,1,9.63,9.63,0,0,0-5,8.59c0,3,0,6,0,9,0,1.18-.1,1.28-1.27,1.29-2.45,0-4.89,0-7.34,0A5.28,5.28,0,0,0,0,65.33V83.41c0,3.6,2.21,5.8,5.85,5.82h6.91c1.44,0,1.49.05,1.49,1.5,0,3,0,6,0,8.93a9.28,9.28,0,0,0,9,9.37c20.85-.05,41.69,0,62.54,0a7.89,7.89,0,0,0,4-.91,9.49,9.49,0,0,0,5-8.56c.08-3,0-6,0-9,0-1.17.11-1.27,1.29-1.27h7c3.25,0,5.08-1.45,5.84-4.57V64.46C108.78,63.73,108.88,62.92,108.4,62.25ZM27.51,28a27.22,27.22,0,0,1,54-1,49.76,49.76,0,0,1,.26,7.22c0,1.6-.05,3.19,0,4.79,0,.84-.25,1-1,1-1.74,0-3.48,0-5.21,0-.8,0-1.09-.14-1.07-1,.06-2.62,0-5.25,0-7.87a20,20,0,0,0-16.85-20c-10.9-1.91-21.82,6.32-22.93,17.3-.36,3.5-.13,7-.15,10.52,0,.86-.25,1.06-1.06,1-1.85-.06-3.69,0-5.53,0-.47,0-.71-.07-.7-.62C27.42,35.55,27.12,31.75,27.51,28Zm43.4,7c0,1.38,0,2.76,0,4.14,0,.71-.21.88-.89.88-5.17,0-10.35,0-15.52,0s-10.13,0-15.19,0c-1,0-1.17-.28-1.14-1.18.13-3.36-.17-6.73.19-10.09A16.33,16.33,0,0,1,70.64,28,38,38,0,0,1,70.91,35ZM18.22,58.7c.05-3.05,0-6.09,0-9.14,0-3.74,2.22-6,5.92-6H85c3.65,0,5.89,2.23,5.9,5.89,0,3.12,0,6.24,0,9.35,0,.88-.23,1.12-1.11,1.12q-17.65,0-35.3,0c-11.69,0-23.39,0-35.08,0C18.4,60,18.2,59.64,18.22,58.7ZM90.91,90.08c-.06,3.08,0,6.17,0,9.25,0,3.71-2.26,6-6,6H24.2c-3.7,0-5.95-2.25-6-6,0-3.08,0-6.17,0-9.25,0-.92.18-1.17,1.14-1.17,11.74,0,23.47,0,35.2,0s23.47,0,35.2,0C90.72,88.91,90.93,89.16,90.91,90.08Zm14.49-7.15c0,1.8-.61,2.38-2.45,2.38H6.29c-2,0-2.56-.53-2.56-2.59V65.92c0-1.77.58-2.37,2.34-2.37h97c1.77,0,2.35.6,2.36,2.36Zm-5.7-4.86c-1.7,0-3.4,0-5.1,0s-3.54,0-5.31,0c-1.27,0-2,.7-2,1.81a1.8,1.8,0,0,0,2,1.8q5.2,0,10.41,0a1.82,1.82,0,1,0,0-3.61ZM80.41,76.16l-2.58-1.74c1-.68,1.93-1.28,2.83-1.9,1.13-.77,1.42-1.77.83-2.7s-1.69-1-2.88-.31a9.38,9.38,0,0,1-2.22,1.34c-.21-3-.53-3.7-1.79-3.64-2.48.14-1.73,2.17-2,3.75-.87-.58-1.65-1.11-2.44-1.6a1.81,1.81,0,1,0-2,3c1,.66,1.93,1.3,3.05,2.05-1.05.7-2,1.31-2.91,1.94a1.84,1.84,0,1,0,2,3l2.38-1.58c0,.85,0,1.49,0,2.11a1.8,1.8,0,0,0,1.8,1.74,1.78,1.78,0,0,0,1.8-1.83c0-.62,0-1.24,0-2l2.11,1.39c1.33.88,2.41.81,3.06-.18S81.79,77.09,80.41,76.16Zm-19.7.19c-.92-.64-1.85-1.26-2.85-1.93,1.07-.72,2-1.35,3-2a1.83,1.83,0,0,0,.67-2.57,1.85,1.85,0,0,0-2.7-.44c-.76.49-1.51,1-2.38,1.58-.25-1.54.51-3.68-1.84-3.72s-1.67,2.18-2,3.71c-.82-.55-1.54-1-2.28-1.51a1.87,1.87,0,0,0-2.78.38,1.83,1.83,0,0,0,.76,2.62c.94.65,1.9,1.28,2.93,2-.59.4-1.05.73-1.52,1s-1,.65-1.5,1A1.81,1.81,0,0,0,47.59,79a1.85,1.85,0,0,0,2.7.43c.77-.49,1.52-1,2.36-1.57.29,1.54-.49,3.77,2,3.74s1.61-2.19,1.83-3.6c.11,0,.2,0,.25,0l2,1.34c1.11.72,2.19.59,2.79-.32S61.82,77.11,60.71,76.35ZM40.85,72.43a1.83,1.83,0,1,0-2-3,15.74,15.74,0,0,1-2.38,1.47c0-.66,0-1.23,0-1.79a1.82,1.82,0,0,0-1.83-1.92c-1.08,0-1.73.71-1.8,1.94a5.4,5.4,0,0,1-.13,1.81c-.84-.55-1.59-1.07-2.36-1.56a1.84,1.84,0,0,0-2.69.47,1.79,1.79,0,0,0,.7,2.55c1,.66,1.92,1.3,3,2-1,.7-2,1.33-3,2a1.82,1.82,0,1,0,2,3c.77-.48,1.53-1,2.45-1.6,0,.75,0,1.28,0,1.81,0,1.28.73,2,1.81,2s1.78-.8,1.82-2.06c0-.54,0-1.08,0-1.77,1,.65,1.81,1.22,2.65,1.72a1.73,1.73,0,0,0,2.08-.11,1.75,1.75,0,0,0,.61-1.91,2.25,2.25,0,0,0-1.08-1.25c-.92-.61-1.83-1.23-2.79-1.89l1.54-1C39.91,73.06,40.39,72.76,40.85,72.43ZM23.7,56.26a1.76,1.76,0,0,0,1.79-1.84c.05-1,.05-1.92,0-2.87,0-.54.13-.75.71-.73,1,0,2,0,3,0A1.8,1.8,0,0,0,31,49a1.76,1.76,0,0,0-1.79-1.73c-.92,0-1.84,0-2.76,0h0c-.85,0-1.7,0-2.55,0a1.75,1.75,0,0,0-2,1.79c-.06,1.81-.06,3.62,0,5.42A1.78,1.78,0,0,0,23.7,56.26ZM21.56,69.79a1.82,1.82,0,0,0-2.7-.37c-.76.49-1.5,1-2.3,1.53-.39-3.24-.7-3.8-2-3.76s-1.64.72-1.76,3.82c-.88-.59-1.63-1.1-2.4-1.59a1.84,1.84,0,0,0-2.7.36,1.8,1.8,0,0,0,.67,2.64c.81.56,1.64,1.11,2.48,1.64.41.26.45.45,0,.73-.78.48-1.54,1-2.3,1.52-1.2.81-1.5,1.79-.85,2.75s1.69,1,2.89.25A9.85,9.85,0,0,1,12.83,78c0,.62,0,1.15,0,1.68,0,1.26.74,2,1.81,2a1.88,1.88,0,0,0,1.81-2.07c0-.54,0-1.08,0-1.77,1,.65,1.79,1.21,2.63,1.72a1.8,1.8,0,0,0,2.71-2,2.15,2.15,0,0,0-1.07-1.26c-.92-.61-1.84-1.24-2.81-1.9,1.07-.71,2-1.32,2.95-2A1.85,1.85,0,0,0,21.56,69.79Zm7.6-22.57c-.92,0-1.84,0-2.76,0h0c-.85,0-1.7,0-2.55,0a1.75,1.75,0,0,0-2,1.79c-.06,1.81-.06,3.62,0,5.42a1.8,1.8,0,1,0,3.59,0c.05-1,.05-1.92,0-2.87,0-.54.13-.75.71-.73,1,0,2,0,3,0A1.8,1.8,0,0,0,31,49,1.76,1.76,0,0,0,29.16,47.22Zm0,0c-.92,0-1.84,0-2.76,0h0c-.85,0-1.7,0-2.55,0a1.75,1.75,0,0,0-2,1.79c-.06,1.81-.06,3.62,0,5.42a1.8,1.8,0,1,0,3.59,0c.05-1,.05-1.92,0-2.87,0-.54.13-.75.71-.73,1,0,2,0,3,0A1.8,1.8,0,0,0,31,49,1.76,1.76,0,0,0,29.16,47.22Z" />
                                                <path class="cls-1" d="M20.87,72.44c-.93.65-1.88,1.26-2.95,2,1,.66,1.89,1.29,2.81,1.9a2.15,2.15,0,0,1,1.07,1.26,1.8,1.8,0,0,1-2.71,2c-.84-.51-1.64-1.07-2.63-1.72,0,.69,0,1.23,0,1.77a1.88,1.88,0,0,1-1.81,2.07c-1.07,0-1.78-.77-1.81-2,0-.53,0-1.06,0-1.68a9.85,9.85,0,0,0-2.25,1.34c-1.2.76-2.27.68-2.89-.25s-.35-1.94.85-2.75c.76-.52,1.52-1,2.3-1.52.45-.28.41-.47,0-.73C10,73.53,9.17,73,8.36,72.42a1.8,1.8,0,0,1-.67-2.64,1.84,1.84,0,0,1,2.7-.36c.77.49,1.52,1,2.4,1.59.12-3.1.44-3.77,1.76-3.82s1.62.52,2,3.76c.8-.53,1.54-1,2.3-1.53a1.82,1.82,0,0,1,2.7.37A1.85,1.85,0,0,1,20.87,72.44Z" />
                                                <path class="cls-1" d="M39.44,73.37l-1.54,1c1,.66,1.87,1.28,2.79,1.89a2.25,2.25,0,0,1,1.08,1.25,1.75,1.75,0,0,1-.61,1.91,1.73,1.73,0,0,1-2.08.11c-.84-.5-1.65-1.07-2.65-1.72,0,.69,0,1.23,0,1.77,0,1.26-.75,2.06-1.82,2.06s-1.77-.76-1.81-2c0-.53,0-1.06,0-1.81-.92.6-1.68,1.12-2.45,1.6a1.82,1.82,0,1,1-2-3c.95-.66,1.92-1.29,3-2-1.08-.72-2-1.36-3-2a1.79,1.79,0,0,1-.7-2.55,1.84,1.84,0,0,1,2.69-.47c.77.49,1.52,1,2.36,1.56a5.4,5.4,0,0,0,.13-1.81c.07-1.23.72-1.93,1.8-1.94a1.82,1.82,0,0,1,1.83,1.92c0,.56,0,1.13,0,1.79a15.74,15.74,0,0,0,2.38-1.47,1.83,1.83,0,1,1,2,3C40.39,72.76,39.91,73.06,39.44,73.37Z" />
                                                <path class="cls-1" d="M61.51,79.05c-.6.91-1.68,1-2.79.32l-2-1.34s-.14,0-.25,0c-.22,1.41.51,3.56-1.83,3.6s-1.66-2.2-2-3.74c-.84.56-1.59,1.08-2.36,1.57a1.85,1.85,0,0,1-2.7-.43,1.81,1.81,0,0,1,.67-2.57c.49-.34,1-.66,1.5-1s.93-.64,1.52-1c-1-.69-2-1.32-2.93-2a1.83,1.83,0,0,1-.76-2.62,1.87,1.87,0,0,1,2.78-.38c.74.47,1.46,1,2.28,1.51.29-1.53-.5-3.75,2-3.71S56.2,69.43,56.45,71c.87-.57,1.62-1.09,2.38-1.58a1.85,1.85,0,0,1,2.7.44,1.83,1.83,0,0,1-.67,2.57c-1,.67-1.93,1.3-3,2,1,.67,1.93,1.29,2.85,1.93C61.82,77.11,62.12,78.13,61.51,79.05Z" />
                                                <path class="cls-1" d="M81.49,79c-.65,1-1.73,1.06-3.06.18l-2.11-1.39c0,.79,0,1.41,0,2a1.78,1.78,0,0,1-1.8,1.83,1.8,1.8,0,0,1-1.8-1.74c-.06-.62,0-1.26,0-2.11l-2.38,1.58a1.84,1.84,0,1,1-2-3c.93-.63,1.86-1.24,2.91-1.94-1.12-.75-2.1-1.39-3.05-2.05a1.81,1.81,0,1,1,2-3c.79.49,1.57,1,2.44,1.6.24-1.58-.51-3.61,2-3.75,1.26-.06,1.58.65,1.79,3.64a9.38,9.38,0,0,0,2.22-1.34c1.19-.74,2.28-.64,2.88.31s.3,1.93-.83,2.7c-.9.62-1.81,1.22-2.83,1.9l2.58,1.74C81.79,77.09,82.14,78,81.49,79Z" />
                                                <path class="cls-1" d="M101.77,79.86a1.87,1.87,0,0,1-2.06,1.82q-5.2,0-10.41,0a1.8,1.8,0,0,1-2-1.8c0-1.11.76-1.8,2-1.81,1.77,0,3.54,0,5.31,0s3.4,0,5.1,0A1.87,1.87,0,0,1,101.77,79.86Z" />
                                                <path class="cls-1" d="M31,49a1.8,1.8,0,0,1-1.77,1.87c-1,0-2,0-3,0-.58,0-.73.19-.71.73,0,1,0,1.92,0,2.87a1.8,1.8,0,1,1-3.59,0c-.06-1.8-.06-3.61,0-5.42a1.75,1.75,0,0,1,2-1.79c.85,0,1.7,0,2.55,0h0c.92,0,1.84,0,2.76,0A1.76,1.76,0,0,1,31,49Z" />
                                                <path class="cls-1" d="M21.8,77.57a1.8,1.8,0,0,1-2.71,2c-.84-.51-1.64-1.07-2.63-1.72,0,.69,0,1.23,0,1.77a1.88,1.88,0,0,1-1.81,2.07c-1.07,0-1.78-.77-1.81-2,0-.53,0-1.06,0-1.68a9.85,9.85,0,0,0-2.25,1.34c-1.2.76-2.27.68-2.89-.25s-.35-1.94.85-2.75c.76-.52,1.52-1,2.3-1.52.45-.28.41-.47,0-.73C10,73.53,9.17,73,8.36,72.42a1.8,1.8,0,0,1-.67-2.64,1.84,1.84,0,0,1,2.7-.36c.77.49,1.52,1,2.4,1.59.12-3.1.44-3.77,1.76-3.82s1.62.52,2,3.76c.8-.53,1.54-1,2.3-1.53a1.82,1.82,0,0,1,2.7.37,1.85,1.85,0,0,1-.69,2.65c-.93.65-1.88,1.26-2.95,2,1,.66,1.89,1.29,2.81,1.9A2.15,2.15,0,0,1,21.8,77.57Z" />
                                                <path class="cls-1" d="M61.51,79.05c-.6.91-1.68,1-2.79.32l-2-1.34s-.14,0-.25,0c-.22,1.41.51,3.56-1.83,3.6s-1.66-2.2-2-3.74c-.84.56-1.59,1.08-2.36,1.57a1.85,1.85,0,0,1-2.7-.43,1.81,1.81,0,0,1,.67-2.57c.49-.34,1-.66,1.5-1s.93-.64,1.52-1c-1-.69-2-1.32-2.93-2a1.83,1.83,0,0,1-.76-2.62,1.87,1.87,0,0,1,2.78-.38c.74.47,1.46,1,2.28,1.51.29-1.53-.5-3.75,2-3.71S56.2,69.43,56.45,71c.87-.57,1.62-1.09,2.38-1.58a1.85,1.85,0,0,1,2.7.44,1.83,1.83,0,0,1-.67,2.57c-1,.67-1.93,1.3-3,2,1,.67,1.93,1.29,2.85,1.93C61.82,77.11,62.12,78.13,61.51,79.05Z" />
                                                <path class="cls-1" d="M41.77,77.55a1.75,1.75,0,0,1-.61,1.91,1.73,1.73,0,0,1-2.08.11c-.84-.5-1.65-1.07-2.65-1.72,0,.69,0,1.23,0,1.77,0,1.26-.75,2.06-1.82,2.06s-1.77-.76-1.81-2c0-.53,0-1.06,0-1.81-.92.6-1.68,1.12-2.45,1.6a1.82,1.82,0,1,1-2-3c.95-.66,1.92-1.29,3-2-1.08-.72-2-1.36-3-2a1.79,1.79,0,0,1-.7-2.55,1.84,1.84,0,0,1,2.69-.47c.77.49,1.52,1,2.36,1.56a5.4,5.4,0,0,0,.13-1.81c.07-1.23.72-1.93,1.8-1.94a1.82,1.82,0,0,1,1.83,1.92c0,.56,0,1.13,0,1.79a15.74,15.74,0,0,0,2.38-1.47,1.83,1.83,0,1,1,2,3c-.46.33-.94.63-1.41.94l-1.54,1c1,.66,1.87,1.28,2.79,1.89A2.25,2.25,0,0,1,41.77,77.55Z" />
                                                <path class="cls-1" d="M81.49,79c-.65,1-1.73,1.06-3.06.18l-2.11-1.39c0,.79,0,1.41,0,2a1.78,1.78,0,0,1-1.8,1.83,1.8,1.8,0,0,1-1.8-1.74c-.06-.62,0-1.26,0-2.11l-2.38,1.58a1.84,1.84,0,1,1-2-3c.93-.63,1.86-1.24,2.91-1.94-1.12-.75-2.1-1.39-3.05-2.05a1.81,1.81,0,1,1,2-3c.79.49,1.57,1,2.44,1.6.24-1.58-.51-3.61,2-3.75,1.26-.06,1.58.65,1.79,3.64a9.38,9.38,0,0,0,2.22-1.34c1.19-.74,2.28-.64,2.88.31s.3,1.93-.83,2.7c-.9.62-1.81,1.22-2.83,1.9l2.58,1.74C81.79,77.09,82.14,78,81.49,79Z" />
                                                <path class="cls-1" d="M101.77,79.86a1.87,1.87,0,0,1-2.06,1.82q-5.2,0-10.41,0a1.8,1.8,0,0,1-2-1.8c0-1.11.76-1.8,2-1.81,1.77,0,3.54,0,5.31,0s3.4,0,5.1,0A1.87,1.87,0,0,1,101.77,79.86Z" />
                                                <path class="cls-1" d="M31,49a1.8,1.8,0,0,1-1.77,1.87c-1,0-2,0-3,0-.58,0-.73.19-.71.73,0,1,0,1.92,0,2.87a1.8,1.8,0,1,1-3.59,0c-.06-1.8-.06-3.61,0-5.42a1.75,1.75,0,0,1,2-1.79c.85,0,1.7,0,2.55,0h0c.92,0,1.84,0,2.76,0A1.76,1.76,0,0,1,31,49Z" />
                                            </svg>

                                            <!-- <img src="<?php echo e(asset('images/Icons_applicant_details.svg')); ?>" width="70px" height="auto" style="margin-right:50px"> -->
                                        </span>
                                        <span class="title" style="display:inline-block">
                                            |&nbsp; <?php echo e(__('Update Password')); ?>

                                        </span>

                                    </a>
                                </h4>
                            </div>
                            <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">

                                    <?php if(Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords())): ?>
                                    <div class="mt-10 sm:mt-0">
                                        
                                            <?php echo $__env->make('profile.update-password-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>

                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.section-border','data' => []]); ?>
<?php $component->withName('jet-section-border'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>


                                </div>
                            </div>
                        </div>
                        <p style="margin-top: 5px;"> &nbsp; </p>
                        


                        <!-- Tab Four -->
                        <!-- <div class="panel panel-default card" style="border-radius: 10px;margin-top:1px">
                            <div class="ppanel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="vertical-align: middle;">
                                        <span style="display:inline-block">

                                            <svg width="70px" height="auto" style="margin-right:50px" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 109.62 109.62">
                                                <defs>
                                                    <style>
                                                        .cls-1 {
                                                            fill: #383838;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="cls-1" d="M108.45,81.19A21.76,21.76,0,0,0,75.71,65.85a2.12,2.12,0,0,1-2.79-.23,40.39,40.39,0,0,0-6.65-4.5,49,49,0,0,0-6.79-3l-1.83-.68,1.63-1.09C67,51.12,71.36,44.41,72.51,35.78a27.58,27.58,0,0,0-7.37-23.25A28.62,28.62,0,0,0,25,10.81a27.14,27.14,0,0,0-9.33,19.94c-.34,10.92,4.41,19.67,14.1,26l1.52,1-2,.92C13.85,65.25,4.53,76.77,1.5,92.93c-.05.28-.07.58-.1.87A5.59,5.59,0,0,1,.94,96v6.46H1.8c1.13,0,2.25,0,3.38,0H5.8c0-.19,0-.42,0-.59a40.39,40.39,0,0,1,6.45-23.41A39.13,39.13,0,0,1,38.69,61.14a40,40,0,0,1,6.53-.54,38.69,38.69,0,0,1,24,8.23,1.66,1.66,0,0,1,.32,2.6,21.56,21.56,0,0,0-4.12,16A21.82,21.82,0,0,0,89.55,106a21.82,21.82,0,0,0,18.9-24.84ZM44.28,55.74h-.11A23.6,23.6,0,0,1,35,53.88a24,24,0,0,1-7.74-5.25A23.66,23.66,0,0,1,27.55,15,23.43,23.43,0,0,1,44.08,8.2h.18A23.72,23.72,0,0,1,60.87,48.85,23.45,23.45,0,0,1,44.28,55.74ZM98.92,96.31a16.84,16.84,0,0,1-12,5h-.08A16.88,16.88,0,0,1,70.07,84.49a16.93,16.93,0,0,1,16.77-17H87a16.89,16.89,0,0,1,12,28.79Z" />
                                                <path class="cls-1" d="M96.72,86.86c-2.41,0-4.82,0-7.23,0H84.27c-2.38,0-4.75,0-7.13,0,0-1.7,0-3.4,0-4.89q9.78,0,19.56,0C96.69,83.34,96.67,85.08,96.72,86.86Z" />
                                            </svg>
                                        </span>
                                        <span class="title" style="display:inline-block">
                                            |&nbsp; <?php echo e(__('Delete Account')); ?>

                                        </span>
                                    </a>
                                </h4>
                            </div>
                            <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                                    -->

                                    <!--                                    

                                </div>
                            </div>
                        </div>
                        <p style="margin-top: 5px;"> &nbsp; </p> -->


                        <!-- Tab Five -->
                        <div class="panel panel-default card" style="border-radius: 10px;margin-top:1px">
                            <div class="ppanel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive" style="vertical-align: middle;">
                                        <span style="display:inline-block">

                                            <svg  height="100%" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 109.02 109.02">
                                                    <defs>
                                                        <style>
                                                            .cls-1 {
                                                                fill: #383838;
                                                            }
                                                        </style>
                                                    </defs>
                                                    <path class="cls-1" d="M103.11,29.81C89.74,27.09,76.37,24.3,63,21.53q-16.77-3.48-33.55-7a5.3,5.3,0,0,0-6.34,4.2c-.86,4.05-1.71,8.11-2.5,12.18-.15.73-.42.93-1.15.93q-6.6-.06-13.2,0A5.19,5.19,0,0,0,.89,37.31q0,25.92,0,51.83a5.19,5.19,0,0,0,5.4,5.42H82.21a5,5,0,0,0,4.92-3.22c.28-.62.58-.64,1.11-.53,1,.22,2,.44,3,.62a5.21,5.21,0,0,0,6.25-4.15c3.09-14.83,6.14-29.67,9.24-44.5a54.69,54.69,0,0,1,1.45-6.48V34.2A6,6,0,0,0,103.11,29.81ZM23.16,31.1c.29-.89.07-2.19.73-2.61s1.7.21,2.58.39q6.34,1.29,12.68,2.6c.36.07.71.18,1.06.28l0,.1c-5.47,0-10.94,0-16.4,0C23.16,31.87,23,31.71,23.16,31.1ZM85,88.57c0,2.52-.94,3.44-3.49,3.44H7c-2.59,0-3.52-.93-3.52-3.52V37.91c0-2.55.92-3.49,3.44-3.49H81.55c2.53,0,3.47.94,3.47,3.47Q85,63.23,85,88.57Zm16.35-32.79q-3.23,15.43-6.43,30.88a2.6,2.6,0,0,1-3.2,2.24c-1.21-.19-2.4-.47-3.59-.69-.42-.07-.61-.27-.56-.71a3,3,0,0,0,0-.52V52.41c4.49.86,8.86,1.71,13.24,2.52C101.42,55,101.48,55.28,101.37,55.78Zm2.15-10.35c-.48,2.14-.93,4.28-1.35,6.44-.11.6-.37.67-.9.56q-6.55-1.27-13.13-2.52c-.36-.06-.55-.17-.55-.58,0-2.61,0-5.22,0-7.92l10.2,2.08c1.7.35,3.41.71,5.11,1C103.46,44.64,103.65,44.84,103.52,45.43ZM105.43,36c-.34,1.85-.74,3.68-1.11,5.53-.09.44-.19.68-.8.55Q95.95,40.45,88.36,39c-.85-.16-.77-.65-.77-1.24,0-3-1.47-5.07-4-5.73a8.13,8.13,0,0,0-2-.13c-7.23,0-14.45-.1-21.68,0a53.11,53.11,0,0,1-12.32-1.28c-7.35-1.6-14.73-3.08-22.1-4.56-1-.19-1.23-.45-1-1.45.47-1.71.74-3.47,1.11-5.21A2.78,2.78,0,0,1,28.45,17c1.37.27,2.91.56,4.44.88L83.83,28.49q9.61,2,19.23,4C105,32.89,105.78,34,105.43,36Z" />
                                                    <path class="cls-1" d="M36.26,84.56c-4.5,0-9,0-13.49,0s-8.93,0-13.39,0c-1.18,0-1.12.52-1.15,1.36s.09,1.31,1.19,1.3c7-.06,14,0,20.92,0,2.09,0,4.18,0,6.28,0,.54,0,.77-.14.7-.7a3.29,3.29,0,0,1,0-.83C37.47,84.78,37.14,84.55,36.26,84.56Z" />
                                                    <path class="cls-1" d="M14.44,52.63c1,0,2,0,3,0s2.17,0,3.25,0a2.6,2.6,0,0,0,2.6-2.6c.05-1.64.05-3.28,0-4.92a2.63,2.63,0,0,0-2.64-2.69c-2.09-.07-4.19-.06-6.28,0a2.65,2.65,0,0,0-2.66,2.67q-.08,2.46,0,4.92A2.62,2.62,0,0,0,14.44,52.63Zm-.16-7.11c0-.43.19-.55.57-.55h5.33c.44,0,.62.14.62.61q0,1.94,0,3.87c0,.51-.19.67-.68.65-.87,0-1.74,0-2.61,0s-1.75,0-2.62,0c-.45,0-.62-.15-.61-.6C14.3,48.17,14.3,46.84,14.28,45.52Z" />
                                                    <rect class="cls-1" x="8.22" y="78.65" width="4.7" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="14.33" y="78.65" width="4.7" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="20.44" y="78.65" width="4.7" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="26.55" y="78.65" width="4.7" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="32.65" y="78.65" width="4.7" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="56.95" y="39.86" width="4.05" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="62.22" y="39.86" width="4.05" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="67.48" y="39.86" width="4.05" height="2.61" rx="0.76" />
                                                    <rect class="cls-1" x="72.74" y="39.86" width="4.05" height="2.61" rx="0.76" />
                                                </svg>

                                                <!-- <img src="<?php echo e(asset('images/Icons_applicant_details.svg')); ?>" width="70px" height="auto" style="margin-right:50px"> -->
                                        </span>
                                        <span class="title" style="display:inline-block">
                                            |&nbsp; <?php echo e(__('Payment Card Information')); ?>

                                        </span>
                                    </a>
                                </h4>
                            </div>
                            <hr style="height:1px;border:none;color:#ccc;background-color:#ccc;">
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">

                                    <?php echo $__env->make('profile.card-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                </div>
                            </div>
                        </div>
                        <p style="margin-top: 5px;"> &nbsp; </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php echo \Livewire\Livewire::scripts(); ?><?php /**PATH C:\Users\Shamshera Hamza\pwg_client_portal\resources\views/profile/show.blade.php ENDPATH**/ ?>