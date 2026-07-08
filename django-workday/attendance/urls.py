from django.urls import path
from . import views

urlpatterns = [
    path("", views.dashboard, name="dashboard"),
    path("clock-in/", views.clock_in, name="clock_in"),
    path("clock-out/", views.clock_out, name="clock_out"),
]