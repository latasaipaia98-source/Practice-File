from django.urls import path
from . import views

urlpatterns = [
    path("", views.my_leave_requests, name="my_leave_requests"),
    path("apply/", views.apply_leave, name="apply_leave"),
    path("manage/", views.manage_leave_requests, name="manage_leave_requests"),
    path("<int:leave_id>/approve/", views.approve_leave, name="approve_leave"),
    path("<int:leave_id>/reject/", views.reject_leave, name="reject_leave"),
]