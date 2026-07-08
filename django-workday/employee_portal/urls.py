from django.urls import path
from . import views

urlpatterns = [
    path("", views.employee_list, name="employee_list"),
    path("add/", views.employee_create, name="employee_create"),
    path("<int:employee_id>/edit/", views.employee_update, name="employee_update"),
    path("<int:employee_id>/delete/", views.employee_delete, name="employee_delete"),
    path("<int:employee_id>/", views.employee_detail, name="employee_detail"),
    path("departments/", views.department_list, name="department_list"),
    path("departments/add/", views.department_create, name="department_create"),
    path("departments/<int:department_id>/", views.department_detail, name="department_detail"),
    path("departments/<int:department_id>/edit/", views.department_update, name="department_update"),
    path("departments/<int:department_id>/delete/", views.department_delete, name="department_delete"),
]
