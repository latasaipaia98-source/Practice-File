from django.contrib import admin
from .models import LeaveRequest


@admin.register(LeaveRequest)
class LeaveRequestAdmin(admin.ModelAdmin):
    list_display = (
        "employee",
        "start_date",
        "end_date",
        "status",
        "submitted_at",
        "reviewed_by",
        "reviewed_at",
    )

    list_filter = ("status", "start_date", "end_date")
    search_fields = (
        "employee__first_name",
        "employee__last_name",
        "reason",
    )