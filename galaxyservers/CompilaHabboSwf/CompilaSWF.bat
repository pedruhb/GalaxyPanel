@title Compilador de SWF - GalaxyServers.
@color a 
@echo Compilador de SWF automatica GalaxyServers.
@echo Desenvolvido por PHB
@echo Compilando a SWF do habbcand Hotel...
@echo ----------------------------------------------------
@echo Substituindo arquivos na .SWF
@abcreplace Habbo.swf 0 Habbo-0/Habbo-0.main.abc
@echo 10 porcento concluido...
@abcreplace Habbo.swf 1 Habbo-1/Habbo-1.main.abc
@echo 15 porcento concluido...
@abcreplace Habbo.swf 2 Habbo-2/Habbo-2.main.abc
@echo 20 porcento concluido...
@rabcasm Habbo-0/Habbo-0.main.asasm
@echo 30 porcento concluido...
@rabcasm Habbo-1/Habbo-1.main.asasm
@echo 35 porcento concluido...
@rabcasm Habbo-2/Habbo-2.main.asasm
@echo 50 porcento concluido...
@abcreplace Habbo.swf 0 Habbo-0/Habbo-0.main.abc
@echo 55 porcento concluido...
@abcreplace Habbo.swf 1 Habbo-1/Habbo-1.main.abc
@echo 60 porcento concluido...
@abcreplace Habbo.swf 2 Habbo-2/Habbo-2.main.abc
@echo 70 porcento concluido...
@rabcasm Habbo-0/Habbo-0.main.asasm
@echo 85 porcento concluido...
@rabcasm Habbo-1/Habbo-1.main.asasm
@echo 100 porcento concluido...
@rabcasm Habbo-2/Habbo-2.main.asasm
@echo off


@echo SWF compilada e enviada com sucesso.