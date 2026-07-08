from django.shortcuts import render

def home(request):
    return render(request, "workday_portal_app/dashboard.html") 
