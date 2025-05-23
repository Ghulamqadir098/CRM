@extends('layouts.layout')

@section('content')
<div class="my-auto">
    <form action="{{ route('admin.customer.update', $customer) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @csrf
        <h6 class="mb-5 text-lg font-bold">Update Customer</h6>
       
        
        <div class="flex flex-col sm:flex-row">
        
            <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name">Full Name*</label>
                    <input id="name" name="name" type="text" value="{{ $customer->name }}" placeholder="Enter Name" class="form-input">
                    @error('name')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Email*</label>
                    <input id="email" name="email" type="email" value="{{ $customer->email }}" placeholder="Enter Email" class="form-input">
                    @error('email')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="phone">Phone*</label>
                    <input id="phone" name="phone" type="text" value="{{ $customer->phone }}" placeholder="Enter Phone no" class="form-input">
                    @error('phone')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="address">Address*</label>
                    <input id="address" name="address" type="text" value="{{ $customer->address }}" placeholder="Enter Address" class="form-input">
                    @error('address')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="company">Company*</label>
                    <input id="company" name="company" type="text" value="{{ $customer->company }}" placeholder="Enter Company" class="form-input">
                    @error('company')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="image">Image</label>
                    <input name="image" type="file" accept="image/*" class="form-input mt-2 w-full">
                    <img src="{{ $customer->image ?? 'assets/images/profile-34.jpeg' }}" alt="image" class="mx-auto h-20 w-20 rounded-full object-cover md:h-32 md:w-32">

                    @error('image')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3 flex justify-end sm:col-span-2">
                    <button class="mr-3">
                        <a href="{{ route('customer.index') }}" class="btn btn-md btn-danger">Cancel</a>
                    </button>
                    <button type="submit" class="btn btn-primary">Update</button>
                   
                </div>
            </div>
        </div>
    </form>
</div>

@endsection