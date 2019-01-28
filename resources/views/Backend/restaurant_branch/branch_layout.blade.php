         @if (Auth::guard('Cashier')->user()->restaurant_id == null)
         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font restaurant">Restaurant  <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($user))
                    @foreach($restaurants as $restaurant)
                        @if($restaurant->id == $user->restaurant_id)
                         <input type="text" class="form-control restaurant" value="{{ $restaurant->name }}" readonly />
                         <input type="hidden" class="form-control restaurant " id="restaurant" name="restaurant" value="{{ $restaurant->id }}" />                     
                       
                        @endif
                    @endforeach                    
                @else
                <select class="form-control restaurant" name="restaurant" id="restaurant">            
                <option >Select Restaurant </option>
                    @foreach($restaurants as $restaurant)
                      <option value="{{$restaurant->id}}" >{{$restaurant->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
     

         <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font branch">Branch <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($user))
                    @foreach($branchs as $branch)
                        @if($branch->id == $user->branch_id)
                         <input type="text" class="form-control branch" value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control branch " id="branch" name="branch" value="{{ $branch->id }}" />                        
                       
                        @endif
                    @endforeach 
                         
                @else
                <select class="form-control branch " name="branch" id="branch">            
                <option selected disabled>Select Branch </option>
                    @foreach($branchs as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
          @elseif (Auth::guard('Cashier')->user()->branch_id == null || Auth::guard('Cashier')->user()->branch_id == 0 )
        <div class="form-group">
            <label for="member-type" class="col-sm-3 control-label left-align label-font branch">Branch <span class="require">*</span></label>
            <div class="col-sm-7">                 
                 @if(isset($user))
                    @foreach($branchs as $branch)
                        @if($branch->id == $user->branch_id)
                         <input type="text" class="form-control branch " value="{{ $branch->name }}" readonly />
                         <input type="hidden" class="form-control branch" id="branch" name="branch" value="{{ $branch->id }}" />                        
                       
                        @endif
                    @endforeach  
                      
                @else
                <select class="form-control branch" name="branch" id="branch">            
                <option selected disabled>Select Branch </option>
                    @foreach($branchs as $branch)
                      <option value="{{$branch->id}}">{{$branch->name}}</option>                
                    @endforeach
                @endif
                </select>
              
            </div>
        </div>
        @endif