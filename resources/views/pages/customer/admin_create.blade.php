@extends('layouts.layout')

@section('content')
<div class="my-auto">
    <form action="{{ route('customer.form.post') }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @csrf
        <h6 class="mb-5 text-lg font-bold">Add Customer</h6>
        
        <div class="flex flex-col sm:flex-row">
           
            <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name">Full Name*</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Enter Name" class="form-input">
                    @error('name')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Email*</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter Email" class="form-input">
                    @error('email')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="phone">Phone*</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Enter Phone no" class="form-input">
                    @error('phone')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="address">Address*</label>
                    <input id="address" name="address" type="text" value="{{ old('address') }}" placeholder="Enter Address" class="form-input">
                    @error('address')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="company">Company*</label>
                    <input id="company" name="company" type="text" value="{{ old('company') }}" placeholder="Enter Company" class="form-input">
                    @error('company')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password">Password*</label>
                    <input id="password" name="password" type="password" placeholder="Enter Password" class="form-input">
                    @error('password')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation">Password Confirm*</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password" class="form-input">
                    @error('password_confirmation')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="Image">Image*</label>
               
                    <input name="image" type="file" accept="image/*" class="form-input  w-full">
                    @error('image')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3 flex justify-end sm:col-span-2">
                    <button class="mr-3">
                        <a href="{{ route('customer.index') }}" class="btn btn-md btn-danger">Cancel</a>
                    </button>
                    <button type="submit" class="btn btn-primary">Add</button>
                   
                </div>
            </div>
        </div>
    </form>
</div>

@endsection