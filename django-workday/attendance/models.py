from django.db import models
from employee_portal.models import Employee

class AttendanceRecord(models.Model):
    employee = models.ForeignKey(
        Employee,
        on_delete=models.CASCADE,
        null=True,
        blank=True
    )
    employee_name = models.CharField(max_length=100, blank=True)
    clock_in_time = models.DateTimeField(auto_now_add=True)
    clock_out_time = models.DateTimeField(null=True, blank=True)

    def __str__(self): 
        if self.employee:
            return f"{self.employee} - {self.clock_in_time}"
        return f"{self.employee_name} - {self.clock_in_time}"