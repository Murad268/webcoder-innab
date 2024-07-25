@extends('layouts.app')

@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16">Məlumatlarımız</h5>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-10">
            <div class="card col-span-2">
                <div class="card-body">
                    <div>
                        <form enctype="multipart/form-data" method="post" action="{{ route('siteinfo.update', $model->id) }}">
                            @csrf
                            @method('PATCH')
                            <ul class="flex flex-wrap w-full text-sm font-medium text-center border-b border-slate-200 dark:border-zink-500 nav-tabs">
                                @php
                                $isFirst = true;
                                @endphp
                                @foreach($languages as $language)
                                <li class="group {{ $isFirst ? 'active' : '' }}">
                                    <a href="javascript:void(0);" data-tab-toggle="" data-target="{{ $language->code }}" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border border-transparent group-[.active]:text-custom-500 group-[.active]:border-slate-200 dark:group-[.active]:border-zink-500 group-[.active]:border-b-white dark:group-[.active]:border-b-zink-700 hover:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:active:text-custom-500 dark:group-[.active]:hover:text-white -mb-[1px]">{{ $language->name }}</a>
                                </li>
                                @php
                                $isFirst = false;
                                @endphp
                                @endforeach
                            </ul>

                            <div style="border: 1px solid black; padding: 30px" class="mt-5 mb-4 tab-content">
                                @php
                                $isFirst = true;
                                @endphp
                                @foreach($languages as $language)
                                <div class="tab-pane {{ $isFirst ? 'block' : 'hidden' }}" id="{{ $language->code }}">
                                    <div class="grid grid-cols-1 gap-x-5 sm:grid-cols-2">
                                        <div class="mb-3">
                                            <label for="textArea" class="inline-block mb-2 text-base font-medium">Ünvan ({{ $language->code }})</label>
                                            <textarea name="address[{{ $language->code }}]" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="textArea" rows="3">{{ old('address.' . $language->code, $model->getTranslation('address', $language->code)) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $isFirst = false;
                                @endphp
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label for="facebook_link" class="inline-block mb-2 text-base font-medium">Facebook linki</label>
                                <input type="text" id="facebook_link" name="facebook_link" value="{{ old('facebook_link', $model->facebook_link) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="instagram_link" class="inline-block mb-2 text-base font-medium">Instagram linki</label>
                                <input type="text" id="instagram_link" name="instagram_link" value="{{ old('instagram_link', $model->instagram_link) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="linkedin_link" class="inline-block mb-2 text-base font-medium">LinkedIn linki</label>
                                <input type="text" id="linkedin_link" name="linkedin_link" value="{{ old('linkedin_link', $model->linkedin_link) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="twitter_link" class="inline-block mb-2 text-base font-medium">Twitter linki</label>
                                <input type="text" id="twitter_link" name="twitter_link" value="{{ old('twitter_link', $model->twitter_link) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="youtube_link" class="inline-block mb-2 text-base font-medium">YouTube linki</label>
                                <input type="text" id="youtube_link" name="youtube_link" value="{{ old('youtube_link', $model->youtube_link) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="phone1" class="inline-block mb-2 text-base font-medium">Telefon 1</label>
                                <input type="text" id="phone1" name="phone1" value="{{ old('phone1', $model->phone1) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="phone2" class="inline-block mb-2 text-base font-medium">Telefon 2</label>
                                <input type="text" id="phone2" name="phone2" value="{{ old('phone2', $model->phone2) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="email1" class="inline-block mb-2 text-base font-medium">E-poçt 1</label>
                                <input type="email" id="email1" name="email1" value="{{ old('email1', $model->email1) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="email2" class="inline-block mb-2 text-base font-medium">E-poçt 2</label>
                                <input type="email" id="email2" name="email2" value="{{ old('email2', $model->email2) }}" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="mb-3">
                                <label for="map" class="inline-block mb-2 text-base font-medium">Xəritə</label>
                                <textarea style="height: 200px" name="map" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="map" rows="3">{{ old('map', $model->map) }}</textarea>
                            </div>
                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'nav_logo') as $image)
                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset($image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset($image->url) }}" alt="">
                                        </a>
                                        <a href="{{ route('training.deleteFile', $image->id) }}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="wrapper_image" style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">

                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="">
                                            <img style="width: 100%; height: 100%;" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Yuxarıdakı loqo</label>
                                <input multiple name="nav_logo[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">

                            </div>

                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'footer_logo') as $image)
                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset($image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset($image->url) }}" alt="">
                                        </a>
                                        <a href="{{ route('training.deleteFile', $image->id) }}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="wrapper_image" style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">

                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="">
                                            <img style="width: 100%; height: 100%;" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Aşağıdakı loqo</label>
                                <input multiple name="footer_logo[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">

                            </div>


                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'header_image') as $image)
                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset($image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset($image->url) }}" alt="">
                                        </a>
                                        <a href="{{ route('training.deleteFile', $image->id) }}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="wrapper_image" style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">

                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="">
                                            <img style="width: 100%; height: 100%;" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Seminar & Vebinar ikonu</label>
                                @if($model->images->where('type', 'header_image')->count() < 1) <input multiple name="header_image[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    @endif
                            </div>






                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'vebinar_icon') as $image)
                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset($image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset($image->url) }}" alt="">
                                        </a>
                                        <a href="{{ route('training.deleteFile', $image->id) }}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="wrapper_image" style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">

                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="">
                                            <img style="width: 100%; height: 100%;" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Workshop ikonu</label>
                                <input multiple name="vebinar_icon[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">

                            </div>

                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'workshop_icon') as $image)
                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset($image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset($image->url) }}" alt="">
                                        </a>
                                        <a href="{{ route('training.deleteFile', $image->id) }}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="wrapper_image" style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">

                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="">
                                            <img style="width: 100%; height: 100%;" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Təqaüd proqramları ikon</label>
                                <input multiple name="workshop_icon[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">

                            </div>


                            <div style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">
                                    @foreach($model->images->where('type', 'scholarship_icon') as $image)
                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="{{ asset($image->url) }}">
                                            <img style="width: 100%; height: 100%;" src="{{ asset($image->url) }}" alt="">
                                        </a>
                                        <a href="{{ route('training.deleteFile', $image->id) }}" style="cursor: pointer; position: absolute; top: 0; right: 0; background-color: red; color: white; padding: 6px;" class="delete_image" data-id="{{ $image->id }}">
                                            X
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="wrapper_image" style="margin-bottom: 10px">
                                <div style="display: flex; column-gap: 5px">

                                    <div style="position: relative; width: 250px; height: 100px;">
                                        <a target="_blank" style="display: block; width: 100%; height: 100%;" href="">
                                            <img style="width: 100%; height: 100%;" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="textArea" class="inline-block mb-2 text-base font-medium">Aşağıdakı loqo</label>
                                <input multiple name="scholarship_icon[]" type="file" class="cursor-pointer form-file border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">

                            </div>




                            <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                Yenilə
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const inputFiles = document.querySelectorAll('input[type=file]');
    const wrappers = document.querySelectorAll('.wrapper_image img'); // Düzgün selector daxil edin

    inputFiles.forEach((inputFile, i) => {
        inputFile.addEventListener('change', (event) => {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    wrappers[i].src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });

    function openPdf(url) {
        window.open(url, '_blank');
    }

    document.querySelectorAll('.ckeditortext').forEach((textarea) => {
        CKEDITOR.replace(textarea);
    });

    document.querySelectorAll('.delete_image').forEach((button) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            Swal.fire({
                title: 'Əminsiniz?',
                text: "Bu şəkli silmək istədiyinizdən əminsiniz?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli, silin!',
                cancelButtonText: 'Xeyr, ləğv et!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endpush
