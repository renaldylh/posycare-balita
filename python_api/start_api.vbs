Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "python """ & "C:\\xampp\\htdocs\\posycare\\python_api\\predict_api.py" & """", 0, False
