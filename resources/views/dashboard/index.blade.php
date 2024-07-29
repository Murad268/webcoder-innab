@extends('layouts.app')
@push('styles')
<style>
    .dashboard_wrapper {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 35px;
    }

    .dashboard_item {
        height: 200px;
        border: 1px solid black;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
        text-align: center;
    }
</style>
@endpush
@section('content')
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

        <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
            <div class="grow">
                <h5 class="text-16"> Work-shoplar </h5>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <div class="dashboard_wrapper">
                    <a href="{{route('project.index')}}" class="dashboard_item">
                        <div>
                            <h3>Layihələr və kariyera mərkəzi</h3>
                            <p>sayı: {{$projectRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$projectRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('customer.index')}}" class="dashboard_item">
                        <div>
                            <h3>Müştərilərimiz</h3>
                            <p>sayı: {{$customerRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$customerRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('partners.index')}}" class="dashboard_item">
                        <div>
                            <h3>Tərəfdaşlar</h3>
                            <p>sayı: {{$partnersRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$partnersRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('blog.index')}}" class="dashboard_item">
                        <div>
                            <h3>Bloqlar</h3>
                            <p>sayı: {{$blogContentRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$blogContentRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('videolessons.index')}}" class="dashboard_item">
                        <div>
                            <h3>Video dərslər</h3>
                            <p>sayı: {{$videoLessonsRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$videoLessonsRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('training.index')}}" class="dashboard_item">
                        <div>
                            <h3>Təlimlər</h3>
                            <p>sayı: {{$trainingRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$trainingRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('vebinar.index')}}" class="dashboard_item">
                        <div>
                            <h3>Vebinarlar</h3>
                            <p>sayı: {{$vebinarRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$vebinarRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('workshop.index')}}" class="dashboard_item">
                        <div>
                            <h3>Work-shoplar</h3>
                            <p>sayı: {{$workshopRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$workshopRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                    <a href="{{route('scholarshipprogram.index')}}" class="dashboard_item">
                        <div>
                            <h3>Təqaüd proqramları</h3>
                            <p>sayı: {{$programRepository->getAll()->count()}}</p>
                            <p>aktiv sayı: {{$programRepository->all_active()->count()}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
