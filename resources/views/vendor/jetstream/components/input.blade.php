@props(['disabled' => false])

<style>
        input [type='Text'],
        input [type='number'],
        input [type='password'],
        select {
        /* width: 350px !important; */
        height:60px !important; 
 
        text-align:center !important; 
        color:#000 !important; 
        font-family:'TT Norms Pro' !important; 
        font-weight:700 !important;
        border-color: #6b7280 !important;
        border-width: 1px !important;
    }

    @media (min-width:375px) and (max-width:768px){
        button {
        width: 90% !important;
        height:50px !important; 
      }   
      input [type='Text'] {
        width: 100% !important;
        padding: 0px;
        margin: 0px;
      }
    }
</style>

<input style="height: 60px;" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
