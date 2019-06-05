<div class="card-body">
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
      
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Phone Number</label>
               </div>
               <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                {!! Form::text('phone_number',null,array('class' => 'form-control', "maxlength"=>20,
                                "id"=>'phone',  "placeholder"=>"Phone Number")) !!}
                <span class="error" id="phone_number_error"></span>
               </div>
               <div class="col-md-2 col-lg-2 col-sm-2">
                   <button type="button" class="btn btn-detail" id="search-user" data-url = "{{route('store.findCustomer')}}"><i class="fa fa-search"></i></button>
              </div>
              <input type="hidden" name="customer_id" id="customer_id">
              <input type="hidden" name="address_id" id="address_id">
            </div>
               
          </div>
       
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Name</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('name',null,array('class' => 'form-control', "placeholder"=>"Name", "maxlength"=>50, "id"=>'name')) !!}
                <span class="error" id="name_error"></span>
               </div>
          </div>
        </div>
        <br>

        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Email</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('email',null,array('class' => 'form-control',  "placeholder"=>"Email", "maxlength"=>50, "id"=>'email')) !!}
                <span class="error" id="email_error"></span>
               </div>
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Select Plan Type</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::select('plan_type',$plan_types, null ,array('class' => 'form-control',  "placeholder"=>"Select Plan Type", "maxlength"=>50, "id"=>'plan_type', 'data-url'=>route('store.getPlans'))) 
                !!}
                <span class="error" id="plan_type_error"></span>
               </div>
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
             </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
               <div id="plans">

              </div>
                <span class="error" id="plan_error"></span>
               </div>
              
            </div>
          </div>
       
</div>
</div>
</div>