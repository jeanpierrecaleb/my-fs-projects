from django.shortcuts import render

def index(request):
   return render(request, 'index.html')

def bootstrap(request):
   return render(request, 'bootstrap-5.html')