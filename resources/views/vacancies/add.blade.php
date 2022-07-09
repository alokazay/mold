@if(Auth::user()->isAdmin())
    @include('vacancies.vacancy.include_add')
@else
    @include('vacancies.vacancy.include_view')
@endif
