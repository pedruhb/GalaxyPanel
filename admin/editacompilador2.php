<?php

define('GALAXYSERVERS', 1); 
include '../galaxyservers/config.php';
#region Faz os bagulhos da Habbo.SWF

$GalaxyServersTxt = '<?php
$con_id = ftp_connect("'.$ipftpswf.'") or die("Não conectou no servidor FTP.");
ftp_login( $con_id, "'.$userftpswf.'", "'.$senhaftpswf.'" );
ftp_pasv($con_id, true) or die("Não foi possível entrar no modo passivo."); 
if ( @ftp_put( $con_id, "./"."'.$_GET['uservestacp'].'".".swf", "C:\/xampp\htdocs\galaxyservers\CompilaHabboSwf2\Habbo.swf", FTP_BINARY)) 
{
  echo "SWF upada com sucesso";
} else {
  echo "Erro ao enviar swf.";
}

?>';
$GalaxyServersBat = '@title Compilador de SWF - GalaxyServers.
@color a 
@echo Compilador de SWF automatica GalaxyServers.
@echo Desenvolvido por PHB
@echo Compilando a SWF do '.$_GET['nomehotel'].' Hotel...
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
C:\xampp\php\php.exe C:\xampp\htdocs\galaxyservers\CompilaHabboSwf2\envia.php

@echo SWF compilada e enviada com sucesso.';

/// CameraPhotoLab.class.asasm
$CameraPhotoLab = 'class
 refid "_-3XF:CameraPhotoLab"
 instance QName(PackageNamespace("_-3XF"), "CameraPhotoLab")
  extends QName(PackageNamespace(""), "Object")
  implements Multiname("_-6jQ", [PackageNamespace("_-1M6")])
  flag SEALED
  flag PROTECTEDNS
  protectedns ProtectedNamespace("_-4E0")
  iinit
   refid "_-3XF:CameraPhotoLab/iinit"
   param QName(PackageNamespace("_-3XF"), "_-5zl")
   body
    maxstack 2
    localcount 2
    initscopedepth 4
    maxscopedepth 5
    code
     debugfile           "k"
     debugline           65
     getlocal0
     pushscope

     debug               1, "k", 0, 65
     debugline           55
     getlocal0
     findpropstrict      QName(PackageNamespace("_-07U"), "Map")
     constructprop       QName(PackageNamespace("_-07U"), "Map"), 0
     initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")

     debugline           58
     getlocal0
     findpropstrict      QName(PackageNamespace("_-07U"), "Map")
     constructprop       QName(PackageNamespace("_-07U"), "Map"), 0
     initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2S9")

     debugline           63
     getlocal0
     findpropstrict      QName(PackageNamespace("flash.net"), "FileReference")
     constructprop       QName(PackageNamespace("flash.net"), "FileReference"), 0
     initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-xR")

     debugline           65
     getlocal0
     constructsuper      0

     debugline           66
     getlocal0
     getlocal1
     initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")

     debugline           67
     returnvoid
    end ; code
   end ; body
  end ; method
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD") type QName(PackageNamespace("_-3XF"), "_-5zl") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi") type QName(PackageNamespace("_-X3"), "IWindowContainer") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_disposed") type QName(PackageNamespace(""), "Boolean") value False() end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um") type QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6FI") type QName(PackageNamespace("flash.display"), "BitmapData") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U") type QName(PackageNamespace("_-3XF"), "_-xU") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5kZ") type QName(PackageNamespace("_-1Bv"), "ITextWindow") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270") type QName(PackageNamespace("_-3XF"), "CameraEffect") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf") type QName(PackageNamespace("_-07U"), "Map") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc") type QName(PackageNamespace("_-1Bv"), "_-4--") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5sO") type QName(PackageNamespace("flash.display"), "Sprite") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2S9") type QName(PackageNamespace("_-07U"), "Map") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N") type QName(PackageNamespace(""), "int") value Integer(0) end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2oL") type QName(PackageNamespace(""), "String") value Utf8("") end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5b4") type QName(PackageNamespace(""), "Boolean") value False() end
  trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-xR") type QName(PackageNamespace("flash.net"), "FileReference") end
  trait method QName(PackageNamespace(""), "dispose")
   method
    refid "_-3XF:CameraPhotoLab/dispose"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           69
      getlocal0
      pushscope

      debugline           70
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_disposed")
      iffalse             L11

      debugline           71
      returnvoid

      debugline           73
L11:
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L16

      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      callpropvoid        QName(PackageNamespace(""), "hide"), 0

      debugline           74
L16:
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      callpropvoid        QName(PackageNamespace(""), "_-0GA"), 0

      debugline           75
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6FI")

      debugline           76
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")

      debugline           77
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")

      debugline           78
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      pushnull
      ifeq                L44

      debugline           79
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callpropvoid        QName(PackageNamespace(""), "dispose"), 0

      debugline           80
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")

      debugline           82
L44:
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5kZ")

      debugline           83
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")

      debugline           84
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")

      debugline           85
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2S9")

      debugline           86
      getlocal0
      pushtrue
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_disposed")

      debugline           87
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      iffalse             L71

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      callpropvoid        QName(Namespace("_-2W2"), "dispose"), 0

      debugline           88
L71:
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")

      debugline           89
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait getter QName(PackageNamespace(""), "disposed")
   method
    refid "_-3XF:CameraPhotoLab/disposed/getter"
    returns QName(PackageNamespace(""), "Boolean")
    body
     maxstack 1
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           91
      getlocal0
      pushscope

      debugline           92
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_disposed")
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3Ij")
   method
    refid "_-3XF:CameraPhotoLab/_-3Ij"
    param QName(PackageNamespace("flash.display"), "BitmapData")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           95
      getlocal0
      pushscope

      debug               1, "k", 0, 95
      debugline           96
      getlocal0
      getlocal1
      callproperty        QName(PackageNamespace(""), "clone"), 0
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6FI")

      debugline           97
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")
      getlocal1
      setproperty         QName(Namespace("_-5Rl"), "bitmap")

      debugline           98
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2q5"), 0

      debugline           99
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageInternalNs("_-3XF"), "_-4Wi")
   method
    refid "_-3XF:CameraPhotoLab/_-3XF:_-4Wi"
    param QName(PackageNamespace(""), "Number")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           101
      getlocal0
      pushscope

      debug               1, "k", 0, 101
      debugline           102
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      iffalse             L21

      debugline           103
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      getlocal1
      setproperty         QName(PackageNamespace(""), "value")

      debugline           104
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-07d"), 0

      debugline           105
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2H6"), 0

      debugline           107
L21:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-07d")
   method
    refid "_-3XF:CameraPhotoLab/_-07d"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 6
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           109
      getlocal0
      pushscope

      debugline           110
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5kZ")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      getproperty         QName(PackageNamespace(""), "description")
      pushstring          " "
      add
      getlex              QName(PackageNamespace(""), "int")
      getglobalscope
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      callproperty        QName(PackageNamespace(""), "_-1uf"), 0
      pushbyte            100
      multiply
      call                1
      add
      pushstring          "%"
      add
      setproperty         QName(Namespace("_-3oN"), "text")

      debugline           111
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5kZ")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5kZ")
      getproperty         QName(Namespace("_-3oN"), "textWidth")
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3sO")
      add
      setproperty         QName(Namespace("_-6q"), "width")

      debugline           112
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageInternalNs("_-3XF"), "_-15n")
   method
    refid "_-3XF:CameraPhotoLab/_-3XF:_-15n"
    param QName(PackageNamespace(""), "String")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 3
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           114
      getlocal0
      pushscope

      debug               1, "k", 0, 114
      debugline           115
      findpropstrict      QName(PackageNamespace("_-1Bv"), "ITextWindow")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "captionInput"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callproperty        QName(PackageNamespace("_-1Bv"), "ITextWindow"), 1
      getlocal1
      setproperty         QName(Namespace("_-3oN"), "text")

      debugline           116
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-4DB")
   method
    refid "_-3XF:CameraPhotoLab/_-4DB"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 6
     localcount 6
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           118
      getlocal0
      pushscope

      debug               1, "k", 0, 121
      debug               1, "k", 1, 122
      debug               1, "k", 2, 123
      debug               1, "k", 3, 125
      debug               1, "k", 4, 129
      debugline           119
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2S9")
      getproperty         QName(PackageNamespace(""), "length")
      pushbyte            0
      ifngt               L17

      returnvoid

      debugline           121
L17:
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      getlex              QName(PackageNamespace("_-1Bv"), "IFrameWindow")
      astypelate
      getproperty         QName(Namespace("_-jF"), "margins")
      getproperty         QName(Namespace("_-6KA"), "left")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc")
      getproperty         QName(Namespace("_-6q"), "x")
      add
      convert_i
      setlocal1

      debugline           122
      pushbyte            6
      setlocal2

      debugline           123
      pushbyte            2
      setlocal3

      debugline           125
      getlocal0
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-3FF")
      pushstring          "camera_icon_colorfilter"
      callproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5af"), 2
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal            4

      debugline           126
      getlocal            4
      getlocal1
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc")
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal3
      getlocal            4
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal2
      add
      multiply
      getlocal2
      subtract
      subtract
      pushbyte            2
      divide
      add
      setproperty         QName(Namespace("_-6q"), "x")

      debugline           127
      getlocal            4
      pushbyte            50
      setproperty         QName(Namespace("_-6q"), "y")

      debugline           128
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      getlocal            4
      callpropvoid        QName(Namespace("_-3si"), "addChild"), 1

      debugline           129
      getlocal0
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-4m-")
      pushstring          "camera_icon_compositefilter"
      callproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5af"), 2
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal            5

      debugline           130
      getlocal            5
      getlocal            4
      getproperty         QName(Namespace("_-6q"), "right")
      getlocal2
      add
      setproperty         QName(Namespace("_-6q"), "x")

      debugline           131
      getlocal            5
      getlocal            4
      getproperty         QName(Namespace("_-6q"), "y")
      setproperty         QName(Namespace("_-6q"), "y")

      debugline           132
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      getlocal            5
      callpropvoid        QName(Namespace("_-3si"), "addChild"), 1

      debugline           140
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2q5")
   method
    refid "_-3XF:CameraPhotoLab/_-2q5"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 5
     localcount 10
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           142
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal3

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal            5

      pushnull
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal            6

      pushnull
      coerce_s
      setlocal            7

      debug               1, "k", 0, 147
      debug               1, "k", 1, 148
      debug               1, "k", 2, 153
      debug               1, "k", 3, 154
      debug               1, "k", 4, 156
      debug               1, "k", 5, 168
      debugline           143
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      callproperty        QName(PackageNamespace(""), "_-zs"), 0
      pushfalse
      ifne                L34

      debugline           144
      findpropstrict      QName(PackageNamespace("flash.utils"), "setTimeout")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2q5")
      pushshort           200
      callpropvoid        QName(PackageNamespace("flash.utils"), "setTimeout"), 2

      debugline           147
L34:
      pushbyte            0
      setlocal1

      debugline           148
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "handler")
      getproperty         QName(PackageNamespace(""), "_-2WV")
      getproperty         QName(PackageNamespace(""), "questEngine")
      coerce              QName(PackageNamespace("_-xy"), "_-11R")
      setlocal2

      debugline           149
      getlocal2
      pushnull
      ifeq                L56

      debugline           150
      getlocal2
      pushstring          "explore"
      pushstring          "ACH_CameraPhotoCount"
      callproperty        QName(Namespace("_-0zS"), "_-0Vq"), 2
      convert_i
      setlocal1

      debugline           154
L56:
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      debugline           154
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "component")
      pushstring          "camera.available.effects"
      callproperty        QName(PackageNamespace(""), "getProperty"), 1
      debugline           155
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "localizations")
      callproperty        QName(PackageNamespace(""), "_-2h0"), 2
      coerce              QName(PackageNamespace("_-07U"), "Map")
      setlocal            4

      debugline           156
      pushbyte            0
      setlocal            8

      getlocal            4
      coerce_a
      setlocal            9

      jump                L128

L77:
      label
      getlocal            9
      getlocal            8
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal            5

      debugline           157
      getlocal0
      getlocal            5
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6FI")
      callproperty        QName(PackageNamespace(""), "clone"), 0
      getlocal1
      callproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1Pw"), 3
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal3

      debugline           158
      getlocal3
      iffalse             L128

      debug               1, "k", 6, 159
      debugline           159
      getlocal            5
      getproperty         QName(PackageNamespace(""), "description")
      coerce_s
      setlocal            7

      debugline           160
      getlocal1
      getlocal            5
      getproperty         QName(PackageNamespace(""), "_-4rT")
      ifnlt               L122

      debugline           161
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "localizations")
      pushstring          "camera.effect.required.level"
      callproperty        QName(Namespace("_-US"), "getLocalization"), 1
      pushstring          " "
      debugline           162
      add
      getlocal            5
      getproperty         QName(PackageNamespace(""), "_-4rT")
      add
      coerce_s
      setlocal            7

      debugline           164
L122:
      findpropstrict      QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      getlocal3
      callproperty        QName(PackageNamespace("_-1Bv"), "IRegionWindow"), 1
      getlocal            7
      setproperty         QName(Namespace("_-5AP"), "_-0c4")

      debugline           156
L128:
      hasnext2            9, 8
      iftrue              L77

      kill                9
      kill                8
      debugline           168
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "slider_container"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-X3"), "IWindowContainer")
      astypelate
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal            6

      debugline           169
      getlocal0
      findpropstrict      QName(PackageNamespace("_-3XF"), "_-xU")
      getlocal0
      getlocal            6
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "windowManager")
      getproperty         QName(Namespace("_-4hF"), "assets")
      constructprop       QName(PackageNamespace("_-3XF"), "_-xU"), 3
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")

      debugline           170
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callpropvoid        QName(PackageNamespace(""), "disable"), 0

      debugline           171
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callproperty        QName(PackageNamespace(""), "_-ly"), 0
      callpropvoid        QName(PackageNamespace(""), "_-4b6"), 1

      debugline           173
      getlocal0
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-3FF")
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6Ys"), 1

      debugline           174
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5af")
   method
    refid "_-3XF:CameraPhotoLab/_-5af"
    param QName(PackageNamespace(""), "String")
    param QName(PackageNamespace(""), "String")
    returns QName(PackageNamespace("_-X3"), "IWindowContainer")
    body
     maxstack 3
     localcount 5
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           189
      getlocal0
      pushscope

      debug               1, "k", 0, 189
      debug               1, "k", 1, 189
      debug               1, "k", 2, 190
      debug               1, "k", 3, 191
      debugline           190
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      pushstring          "camera_typebutton"
      callproperty        QName(PackageNamespace(""), "getXmlWindow"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      setlocal3

      debugline           191
      getlocal3
      pushstring          "icon"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      setlocal            4

      debugline           192
      getlocal            4
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "windowManager")
      getproperty         QName(Namespace("_-4hF"), "assets")
      getlocal2
      callproperty        QName(Namespace("_-0LM"), "getAssetByName"), 1
      getproperty         QName(Namespace("_-6i0"), "content")
      getlex              QName(PackageNamespace("flash.display"), "BitmapData")
      astypelate
      callproperty        QName(PackageNamespace(""), "clone"), 0
      setproperty         QName(Namespace("_-5Rl"), "bitmap")

      debugline           193
      getlocal3
      pushstring          "typebutton,"
      getlocal1
      add
      setproperty         QName(Namespace("_-6q"), "name")

      debugline           194
      getlocal3
      getlocal1
      setproperty         QName(Namespace("_-5AP"), "_-0c4")

      debugline           195
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2S9")
      getlocal1
      getlocal3
      callpropvoid        QName(PackageNamespace(""), "add"), 2

      debugline           196
      getlocal3
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1Pw")
   method
    refid "_-3XF:CameraPhotoLab/_-1Pw"
    param QName(PackageNamespace("_-3XF"), "CameraEffect")
    param QName(PackageNamespace("flash.display"), "BitmapData")
    param QName(PackageNamespace(""), "int")
    returns QName(PackageNamespace("_-X3"), "IWindowContainer")
    body
     maxstack 7
     localcount 11
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           202
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      setlocal            5

      pushnan
      setlocal            6

      pushnull
      coerce              QName(PackageNamespace("flash.geom"), "Matrix")
      setlocal            7

      pushnull
      coerce              QName(PackageNamespace("flash.display"), "Bitmap")
      setlocal            8

      pushnull
      coerce              QName(PackageNamespace("_-X3"), "IWindow")
      setlocal            9

      debug               1, "k", 0, 202
      debug               1, "k", 1, 202
      debug               1, "k", 2, 202
      debug               1, "k", 3, 203
      debugline           203
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      pushstring          "camera_filterbutton"
      callproperty        QName(PackageNamespace(""), "getXmlWindow"), 1
      getlex              QName(PackageNamespace("_-X3"), "IWindowContainer")
      astypelate
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal            4

      debugline           204
      getlocal3
      getlocal1
      getproperty         QName(PackageNamespace(""), "_-4rT")
      ifnge               L205

      debug               1, "k", 4, 205
      debug               1, "k", 5, 207
      debug               1, "k", 6, 208
      debug               1, "k", 7, 210
      debugline           205
      getlocal            4
      pushstring          "content"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      setlocal            5

      debugline           206
      getlocal            5
      findpropstrict      QName(PackageNamespace("flash.display"), "BitmapData")
      getlocal            5
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal            5
      getproperty         QName(Namespace("_-6q"), "height")
      pushtrue
      pushbyte            0
      constructprop       QName(PackageNamespace("flash.display"), "BitmapData"), 4
      setproperty         QName(Namespace("_-5Rl"), "bitmap")

      debugline           207
      getlocal            5
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal2
      getproperty         QName(PackageNamespace(""), "width")
      divide
      convert_d
      setlocal            6

      debugline           208
      findpropstrict      QName(PackageNamespace("flash.geom"), "Matrix")
      constructprop       QName(PackageNamespace("flash.geom"), "Matrix"), 0
      coerce              QName(PackageNamespace("flash.geom"), "Matrix")
      setlocal            7

      debugline           209
      getlocal            7
      getlocal            6
      getlocal            6
      callpropvoid        QName(PackageNamespace(""), "scale"), 2

      debugline           210
      findpropstrict      QName(PackageNamespace("flash.display"), "Bitmap")
      getlocal2
      getlex              QName(PackageNamespace("flash.display"), "PixelSnapping")
      getproperty         QName(PackageNamespace(""), "AUTO")
      pushtrue
      constructprop       QName(PackageNamespace("flash.display"), "Bitmap"), 3
      coerce              QName(PackageNamespace("flash.display"), "Bitmap")
      setlocal            8

      jump                L157

L87:
      label
      debugline           213
      getlocal2
      getlocal2
      getlocal2
      getproperty         QName(PackageNamespace(""), "rect")
      findpropstrict      QName(PackageNamespace("flash.geom"), "Point")
      pushbyte            0
      dup
      constructprop       QName(PackageNamespace("flash.geom"), "Point"), 2
      getlocal1
      pushtrue
      callproperty        QName(PackageNamespace(""), "_-6Dt"), 1
      callpropvoid        QName(PackageNamespace(""), "applyFilter"), 4

      debugline           214
      jump                L188

L103:
      label
      debugline           216
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      getlocal1
      getproperty         QName(PackageNamespace(""), "name")
      callproperty        QName(PackageNamespace(""), "getImage"), 1
      pushnull
      ifne                L115

      debugline           217
      pushnull
      returnvalue

      debugline           219
L115:
      getlocal2
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      getlocal1
      getproperty         QName(PackageNamespace(""), "name")
      callproperty        QName(PackageNamespace(""), "getImage"), 1
      pushnull
      pushnull
      getlocal1
      getproperty         QName(PackageNamespace(""), "_-3bl")
      pushnull
      pushtrue
      callpropvoid        QName(PackageNamespace(""), "draw"), 6

      debugline           220
      jump                L188

L129:
      label
      debugline           222
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      getlocal1
      getproperty         QName(PackageNamespace(""), "name")
      callproperty        QName(PackageNamespace(""), "getImage"), 1
      pushnull
      ifne                L141

      debugline           223
      pushnull
      returnvalue

      debugline           225
L141:
      getlocal2
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      getlocal1
      getproperty         QName(PackageNamespace(""), "name")
      callproperty        QName(PackageNamespace(""), "getImage"), 1
      pushnull
      pushnull
      pushnull
      pushnull
      pushtrue
      callpropvoid        QName(PackageNamespace(""), "draw"), 6

      debugline           226
      jump                L188

L154:
      label
      jump                L188

      debugline           211
L157:
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      setlocal            10

      debugline           212
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-3FF")
      getlocal            10
      ifstrictne          L168

      pushbyte            0
      jump                L185

      debugline           215
L168:
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-4m-")
      getlocal            10
      ifstrictne          L175

      pushbyte            1
      jump                L185

      debugline           221
L175:
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-2N1")
      getlocal            10
      ifstrictne          L181

      pushbyte            2
      jump                L185

L181:
      jump                L184

      pushbyte            3
      jump                L185

L184:
      pushbyte            3
L185:
      kill                10
      lookupswitch        L154, [L87, L103, L129, L154]

      debugline           228
L188:
      getlocal            5
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      getlocal            8
      getlocal            7
      pushnull
      pushnull
      pushnull
      pushtrue
      callpropvoid        QName(PackageNamespace(""), "draw"), 6

      debugline           230
      getlocal            4
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5Ed")
      setproperty         QName(Namespace("_-6q"), "procedure")

      jump                L217

      debug               1, "k", 8, 232
      debugline           232
L205:
      getlocal            4
      pushstring          "lock_indicator"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-X3"), "IWindow")
      astypelate
      coerce              QName(PackageNamespace("_-X3"), "IWindow")
      setlocal            9

      debugline           233
      getlocal            9
      pushtrue
      setproperty         QName(Namespace("_-6q"), "visible")

      debugline           235
L217:
      getlocal            4
      getlocal1
      getproperty         QName(PackageNamespace(""), "name")
      setproperty         QName(Namespace("_-6q"), "name")

      debugline           236
      getlocal1
      getlocal            4
      setproperty         QName(PackageNamespace(""), "button")

      debugline           237
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      getlocal            4
      getproperty         QName(Namespace("_-6q"), "name")
      getlocal1
      setproperty         MultinameL([PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])

      debugline           238
      getlocal            4
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-69w")
   method
    refid "_-3XF:CameraPhotoLab/_-69w"
    param QName(PackageNamespace("flash.display"), "BitmapData")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 5
     localcount 12
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           241
      getlocal0
      pushscope

      debug               1, "k", 0, 241
      debug               1, "k", 1, 258
      debug               1, "k", 2, 261
      debug               1, "k", 3, 270
      debug               1, "k", 4, 271
      debug               1, "k", 5, 272
      debug               1, "k", 6, 275
      debug               1, "k", 7, 276
      debug               1, "k", 8, 277
      debug               1, "k", 9, 281
      debug               1, "k", 10, 282
      debugline           242
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      pushstring          "camera_editor"
      callproperty        QName(PackageNamespace(""), "getXmlWindow"), 1
      getlex              QName(PackageNamespace("_-X3"), "IWindowContainer")
      astypelate
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")

      debugline           243
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      callpropvoid        QName(Namespace("_-6q"), "center"), 0

      debugline           247
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "component")
      pushstring          "camera.effects.enabled"
      callproperty        QName(PackageNamespace(""), "getProperty"), 1
      pushstring          "true"
      ifeq                L43

      debugline           248
      getlocal0
      pushnull
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5Ur"), 1

      debugline           249
      returnvoid

      debugline           252
L43:
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "item_grid"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "_-4--")
      astypelate
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc")

      debugline           253
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc")
      pushbyte            7
      setproperty         QName(Namespace("_-5Ga"), "spacing")

      debugline           254
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "image"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      astypelate
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")

      debugline           256
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1UM")
      setproperty         QName(Namespace("_-6q"), "procedure")

      debugline           258
      findpropstrict      QName(PackageNamespace("_-1Bv"), "ITextWindow")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "captionInput"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callproperty        QName(PackageNamespace("_-1Bv"), "ITextWindow"), 1
      coerce              QName(PackageNamespace("_-1Bv"), "ITextWindow")
      setlocal2

      debugline           259
      getlocal2
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1Ye")
      setproperty         QName(Namespace("_-6q"), "procedure")

      debugline           261
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "purchase_display_object"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IDisplayObjectWrapper")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IDisplayObjectWrapper")
      setlocal3

      debugline           262
      getlocal0
      findpropstrict      QName(PackageNamespace("flash.display"), "Sprite")
      constructprop       QName(PackageNamespace("flash.display"), "Sprite"), 0
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5sO")

      debugline           263
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5sO")
      getproperty         QName(PackageNamespace(""), "graphics")
      pushint             16711680
      pushbyte            0
      callpropvoid        QName(PackageNamespace(""), "beginFill"), 2

      debugline           264
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5sO")
      getproperty         QName(PackageNamespace(""), "graphics")
      pushbyte            0
      dup
      getlocal3
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal3
      getproperty         QName(Namespace("_-6q"), "height")
      callpropvoid        QName(PackageNamespace(""), "drawRect"), 4

      debugline           265
      getlocal3
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5sO")
      callpropvoid        QName(Namespace("_-3rS"), "setDisplayObject"), 1

      debugline           268
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5sO")
      getlex              QName(PackageNamespace("flash.events"), "MouseEvent")
      getproperty         QName(PackageNamespace(""), "CLICK")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5Ur")
      callpropvoid        QName(PackageNamespace(""), "addEventListener"), 2

      debugline           270
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "zoom_button"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      setlocal            4

      debugline           271
      getlocal            4
      pushstring          "centerizer"
      callproperty        QName(Namespace("_-3si"), "getChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IBorderWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IBorderWindow")
      setlocal            5

      debugline           272
      getlocal            5
      pushstring          "zoom_text"
      callproperty        QName(Namespace("_-3si"), "getChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "ITextWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "ITextWindow")
      setlocal            6

      debugline           273
      getlocal            6
      getlocal            6
      getproperty         QName(Namespace("_-3oN"), "textWidth")
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3sO")
      add
      setproperty         QName(Namespace("_-6q"), "width")

      debugline           275
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "save_button"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IRegionWindow")
      setlocal            7

      debugline           276
      getlocal            7
      pushstring          "centerizer"
      callproperty        QName(Namespace("_-3si"), "getChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IBorderWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IBorderWindow")
      setlocal            8

      debugline           277
      getlocal            8
      pushstring          "save_text"
      callproperty        QName(Namespace("_-3si"), "getChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "ITextWindow")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "ITextWindow")
      setlocal            9

      debugline           278
      getlocal            9
      getlocal            9
      getproperty         QName(Namespace("_-3oN"), "textWidth")
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3sO")
      add
      setproperty         QName(Namespace("_-6q"), "width")

      debugline           281
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "save_click_catcher"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "IDisplayObjectWrapper")
      astypelate
      coerce              QName(PackageNamespace("_-1Bv"), "IDisplayObjectWrapper")
      setlocal            10

      debugline           282
      findpropstrict      QName(PackageNamespace("flash.display"), "Sprite")
      constructprop       QName(PackageNamespace("flash.display"), "Sprite"), 0
      coerce              QName(PackageNamespace("flash.display"), "Sprite")
      setlocal            11

      debugline           283
      getlocal            11
      getproperty         QName(PackageNamespace(""), "graphics")
      pushint             16711680
      pushbyte            0
      callpropvoid        QName(PackageNamespace(""), "beginFill"), 2

      debugline           284
      getlocal            11
      getproperty         QName(PackageNamespace(""), "graphics")
      pushbyte            0
      dup
      getlocal            10
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal            10
      getproperty         QName(Namespace("_-6q"), "height")
      callpropvoid        QName(PackageNamespace(""), "drawRect"), 4

      debugline           285
      getlocal            10
      getlocal            11
      callpropvoid        QName(Namespace("_-3rS"), "setDisplayObject"), 1

      debugline           286
      getlocal            11
      getlex              QName(PackageNamespace("flash.events"), "MouseEvent")
      getproperty         QName(PackageNamespace(""), "CLICK")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3zQ")
      callpropvoid        QName(PackageNamespace(""), "addEventListener"), 2

      debugline           288
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-4DB"), 0

      debugline           289
      getlocal0
      getlocal1
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3Ij"), 1

      debugline           291
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "slider_effect_info"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      getlex              QName(PackageNamespace("_-1Bv"), "ITextWindow")
      astypelate
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5kZ")

      debugline           293
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      callpropvoid        QName(PackageNamespace(""), "_-0GA"), 0

      debugline           294
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5Ed")
   method
    refid "_-3XF:CameraPhotoLab/_-5Ed"
    param QName(PackageNamespace("_-CA"), "WindowEvent")
    param QName(PackageNamespace("_-X3"), "IWindow")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 3
     localcount 4
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           296
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal3

      debug               1, "k", 0, 296
      debug               1, "k", 1, 296
      debugline           298
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-CA"), "WindowMouseEvent")
      getproperty         QName(PackageNamespace(""), "CLICK")
      ifeq                L17

      returnvoid

      debugline           300
L17:
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      pushstring          "remove_effect_button"
      ifne                L62

      debugline           301
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      getlocal2
      getproperty         QName(Namespace("_-6q"), "parent")
      getproperty         QName(Namespace("_-6q"), "name")
      callproperty        QName(PackageNamespace(""), "_-1vD"), 1
      iffalse             L62

      debug               1, "k", 2, 302
      debugline           302
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      getlocal2
      getproperty         QName(Namespace("_-6q"), "parent")
      getproperty         QName(Namespace("_-6q"), "name")
      getproperty         MultinameL([PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal3

      debugline           303
      getlocal3
      pushfalse
      callpropvoid        QName(PackageNamespace(""), "_-32s"), 1

      debugline           304
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      getlocal3
      ifne                L57

      debugline           305
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callpropvoid        QName(PackageNamespace(""), "disable"), 0

      debugline           306
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")

      debugline           308
L57:
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2H6"), 0

      debugline           309
      returnvoid

      debugline           313
L62:
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      callproperty        QName(PackageNamespace(""), "_-1vD"), 1
      iffalse             L77

      debugline           314
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      getproperty         MultinameL([PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-65e"), 1

      debugline           316
L77:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1Ye")
   method
    refid "_-3XF:CameraPhotoLab/_-1Ye"
    param QName(PackageNamespace("_-CA"), "WindowEvent")
    param QName(PackageNamespace("_-X3"), "IWindow")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 4
     localcount 5
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           330
      getlocal0
      pushscope

      debug               1, "k", 0, 330
      debug               1, "k", 1, 330
      debugline           331
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-CA"), "WindowKeyboardEvent")
      getproperty         QName(PackageNamespace(""), "_-65u")
      ifne                L47

      debugline           332
      findpropstrict      QName(PackageNamespace("_-CA"), "WindowKeyboardEvent")
      getlocal1
      callproperty        QName(PackageNamespace("_-CA"), "WindowKeyboardEvent"), 1
      getproperty         QName(PackageNamespace(""), "ctrlKey")
      convert_b
      dup
      iftrue              L27

      pop
      findpropstrict      QName(PackageNamespace("_-CA"), "WindowKeyboardEvent")
      getlocal1
      callproperty        QName(PackageNamespace("_-CA"), "WindowKeyboardEvent"), 1
      getproperty         QName(PackageNamespace(""), "charCode")
      pushbyte            0
      equals
L27:
      iffalse             L34

      debugline           333
      getlocal0
      pushbyte            0
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N")

      jump                L45

      debugline           335
L34:
      getlocal0
      dup
      setlocal3

      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N")
      increment_i
      setlocal            4

      getlocal3
      getlocal            4
      setproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N")

      kill                4
      kill                3
L45:
      jump                L89

      debugline           337
L47:
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-CA"), "WindowKeyboardEvent")
      getproperty         QName(PackageNamespace(""), "_-1Rc")
      ifne                L58

      debugline           338
      getlocal0
      pushbyte            0
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N")

      jump                L89

      debugline           339
L58:
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-CA"), "WindowEvent")
      getproperty         QName(PackageNamespace(""), "_-4aD")
      ifne                L89

      debugline           340
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N")
      pushbyte            1
      ifne                L80

      debugline           341
      getlocal0
      findpropstrict      QName(PackageNamespace("_-1Bv"), "ITextWindow")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "captionInput"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callproperty        QName(PackageNamespace("_-1Bv"), "ITextWindow"), 1
      getproperty         QName(Namespace("_-3oN"), "text")
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2oL")

      jump                L85

      debugline           343
L80:
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2oL")
      callpropvoid        QName(PackageInternalNs("_-3XF"), "_-15n"), 1

      debugline           345
L85:
      getlocal0
      pushbyte            0
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-05N")

      debugline           347
L89:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5Ur")
   method
    refid "_-3XF:CameraPhotoLab/_-5Ur"
    param QName(PackageNamespace("flash.events"), "MouseEvent")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 6
     localcount 6
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           349
      getlocal0
      pushscope

      debug               1, "k", 0, 349
      debug               1, "k", 1, 362
      debugline           350
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L12

      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      callpropvoid        QName(PackageNamespace(""), "hide"), 0

      debugline           352
L12:
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "container")
      getproperty         QName(Namespace("_-6cm"), "sessionDataManager")
      callproperty        QName(Namespace("_-0wj"), "_-1uM"), 0
      iffalse             L41

      debugline           353
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "windowManager")
      pushstring          "${generic.alert.title}"
      pushstring          "${notifications.text.safety_locked}"
      pushbyte            0
      pushnull
      callpropvoid        QName(Namespace("_-4hF"), "alert"), 4

      debugline           354
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "component")
      pushstring          "camera.effects.enabled"
      callproperty        QName(PackageNamespace(""), "getProperty"), 1
      pushstring          "true"
      ifeq                L39

      debugline           355
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "dispose"), 0

      debugline           357
L39:
      returnvoid

      debugline           360
L41:
      findproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      findpropstrict      QName(PackageInternalNs("_-3XF"), "_-IC")
      debugline           360
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      debugline           361
      findpropstrict      QName(PackageNamespace("_-1Bv"), "ITextWindow")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushstring          "captionInput"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callproperty        QName(PackageNamespace("_-1Bv"), "ITextWindow"), 1
      getproperty         QName(Namespace("_-3oN"), "text")
      constructprop       QName(PackageInternalNs("_-3XF"), "_-IC"), 2
      setproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")

      findpropstrict      QName(PackageNamespace("flash.net"), "URLRequest")
      pushstring          "'.$_GET['http'].'://'.$_GET['linkhotel'].'/camera/index.php"
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      callproperty        QName(PackageNamespace(""), "getPhotoData"), 0
      convert_s
      add
      constructprop       QName(PackageNamespace("flash.net"), "URLRequest"), 1
      coerce              QName(PackageNamespace("flash.net"), "URLRequest")
      setlocal            4

      getlocal            4
      getlex              QName(PackageNamespace("_-04A"), "PNGEncoder")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      callproperty        QName(PackageNamespace(""), "encode"), 1
      setproperty         QName(PackageNamespace(""), "data")

      getlocal            4
      pushstring          "application/octet-stream"
      setproperty         QName(PackageNamespace(""), "contentType")

      getlocal            4
      getlex              QName(PackageNamespace("flash.net"), "URLRequestMethod")
      getproperty         QName(PackageNamespace(""), "POST")
      setproperty         QName(PackageNamespace(""), "method")

      findpropstrict      QName(PackageNamespace("flash.net"), "URLLoader")
      constructprop       QName(PackageNamespace("flash.net"), "URLLoader"), 0
      coerce              QName(PackageNamespace("flash.net"), "URLLoader")
      setlocal            5

      getlocal            5
      getlocal            4
      callpropvoid        QName(PackageNamespace(""), "load"), 1

      debugline           362
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      callproperty        QName(PackageNamespace(""), "_-3cF"), 0
      convert_b
      setlocal2

      debugline           363
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      debugline           363
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "handler")
      getproperty         QName(PackageNamespace(""), "_-55u")
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "handler")
      getproperty         QName(PackageNamespace(""), "_-4S2")
      debugline           364
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "handler")
      getproperty         QName(PackageNamespace(""), "_-5mA")
      callpropvoid        QName(PackageNamespace(""), "_-2BV"), 3

      debugline           365
      getlex              QName(PackageNamespace("_-1OR"), "HabboTracking")
      callproperty        QName(PackageNamespace(""), "getInstance"), 0
      pushstring          "Stories"
      pushstring          "camera"
      pushstring          "stories.photo.purchase_dialog_opened"
      callpropvoid        QName(PackageNamespace(""), "trackEventLog"), 3

      debugline           366
      getlocal2
      iftrue              L133

      debugline           367
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      callpropvoid        QName(PackageNamespace(""), "_-5OA"), 0

      debugline           368
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "windowManager")
      pushstring          "${generic.alert.title}"
      pushstring          "${camera.alert.too_much_stuff}"
      pushbyte            0
      pushnull
      callpropvoid        QName(Namespace("_-4hF"), "alert"), 4

      debugline           370
L133:
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "hide"), 0

      debugline           371
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "hide")
   method
    refid "_-3XF:CameraPhotoLab/hide"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           373
      getlocal0
      pushscope

      debugline           374
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushfalse
      setproperty         QName(Namespace("_-6q"), "visible")

      debugline           375
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "show")
   method
    refid "_-3XF:CameraPhotoLab/show"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           377
      getlocal0
      pushscope

      debugline           378
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      pushtrue
      setproperty         QName(Namespace("_-6q"), "visible")

      debugline           379
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-0yU")
   method
    refid "_-3XF:CameraPhotoLab/_-0yU"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           381
      getlocal0
      pushscope

      debugline           382
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L15

      debugline           383
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      callpropvoid        QName(PackageNamespace(""), "hide"), 0

      debugline           384
      findproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      pushnull
      setproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")

      debugline           386
L15:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageInternalNs("_-3XF"), "_-3NI")
   method
    refid "_-3XF:CameraPhotoLab/_-3XF:_-3NI"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 1
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           388
      getlocal0
      pushscope

      debugline           389
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L11

      debugline           390
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      callpropvoid        QName(PackageNamespace(""), "_-0R3"), 0

      debugline           393
L11:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-3Qm")
   method
    refid "_-3XF:CameraPhotoLab/_-3Qm"
    param QName(PackageNamespace("_-wz"), "_-1C2")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           395
      getlocal0
      pushscope

      debug               1, "k", 0, 395
      debugline           396
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L13

      debugline           397
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      getlocal1
      callpropvoid        QName(PackageNamespace(""), "_-3Qm"), 1

      debugline           399
L13:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-3Tz")
   method
    refid "_-3XF:CameraPhotoLab/_-3Tz"
    param QName(PackageNamespace("_-wz"), "_-45C")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           401
      getlocal0
      pushscope

      debug               1, "k", 0, 401
      debugline           402
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L13

      debugline           403
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      getlocal1
      callpropvoid        QName(PackageNamespace(""), "_-3Tz"), 1

      debugline           405
L13:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3zQ")
   method
    refid "_-3XF:CameraPhotoLab/_-3zQ"
    param QName(PackageNamespace("flash.events"), "MouseEvent")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 3
     localcount 7
     initscopedepth 4
     maxscopedepth 7
     code
      debugfile           "k"
      debugline           407
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("flash.globalization"), "DateTimeFormatter")
      setlocal            4

      pushnull
      coerce_s
      setlocal            5

      debug               1, "k", 0, 407
      debug               1, "k", 1, 408
      debug               1, "k", 2, 409
      debugline           408
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      callproperty        QName(PackageNamespace(""), "clone"), 0
      coerce              QName(PackageNamespace("flash.display"), "BitmapData")
      setlocal2

      debugline           409
      getlex              QName(PackageNamespace("_-04A"), "PNGEncoder")
      getlocal2
      callproperty        QName(PackageNamespace(""), "encode"), 1
      coerce              QName(PackageNamespace("flash.utils"), "ByteArray")
      setlocal3

      debugline           412
      debug               1, "k", 3, 412
      debug               1, "k", 4, 414
      debugline           412
L30:
      findpropstrict      QName(PackageNamespace("flash.globalization"), "DateTimeFormatter")
      getlex              QName(PackageNamespace("flash.globalization"), "LocaleID")
      getproperty         QName(PackageNamespace(""), "DEFAULT")
      constructprop       QName(PackageNamespace("flash.globalization"), "DateTimeFormatter"), 1
      coerce              QName(PackageNamespace("flash.globalization"), "DateTimeFormatter")
      setlocal            4

      debugline           413
      getlocal            4
      pushstring          "yyyy-MM-dd_HH-mm-ss"
      callpropvoid        QName(PackageNamespace(""), "setDateTimePattern"), 1

      pushstring          "Habbo_"
      debugline           414
      getlocal            4
      findpropstrict      QName(PackageNamespace(""), "Date")
      constructprop       QName(PackageNamespace(""), "Date"), 0
      callproperty        QName(PackageNamespace(""), "format"), 1
      add
      pushstring          ".png"
      add
      setlocal            5

      debugline           415
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-xR")
      getlocal3
      getlocal            5
      callpropvoid        QName(PackageNamespace(""), "save"), 2

      debugline           416
L57:
      jump                L70

L58:
      getlocal0
      pushscope

      newcatch            0
      dup
      setlocal            6

      dup
      pushscope

      swap
      setslot             1

      popscope
      kill                6
      debugline           418
L70:
      returnvoid
     end ; code
     try from L30 to L57 target L58 type QName(PackageNamespace(""), "Error") name QName(PackageNamespace(""), "error") end
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-1hB")
   method
    refid "_-3XF:CameraPhotoLab/_-1hB"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 5
     localcount 4
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           420
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal1

      debug               1, "k", 0, 421
      debugline           421
      pushbyte            0
      setlocal2

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal3

      jump                L36

L16:
      label
      getlocal3
      getlocal2
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal1

      debugline           422
      getlocal1
      getproperty         QName(PackageNamespace(""), "_-36j")
      iffalse             L36

      debugline           423
      getlex              QName(PackageNamespace("_-1OR"), "HabboTracking")
      callproperty        QName(PackageNamespace(""), "getInstance"), 0
      pushstring          "Stories"
      pushstring          "camera"
      pushstring          "stories.photo.effect.chosen"
      getlocal1
      getproperty         QName(PackageNamespace(""), "name")
      callpropvoid        QName(PackageNamespace(""), "trackEventLog"), 4

      debugline           421
L36:
      hasnext2            3, 2
      iftrue              L16

      kill                3
      kill                2
      debugline           426
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1UM")
   method
    refid "_-3XF:CameraPhotoLab/_-1UM"
    param QName(PackageNamespace("_-CA"), "WindowEvent")
    param QName(PackageNamespace("_-X3"), "IWindow")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 3
     localcount 4
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           427
      getlocal0
      pushscope

      debug               1, "k", 0, 427
      debug               1, "k", 1, 427
      debugline           429
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_disposed")
      convert_b
      dup
      iftrue              L16

      pop
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-Fi")
      not
L16:
      dup
      iftrue              L25

      pop
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-CA"), "WindowMouseEvent")
      getproperty         QName(PackageNamespace(""), "CLICK")
      equals
      not
L25:
      iffalse             L28

      debugline           430
      returnvoid

L28:
      jump                L92

L29:
      label
      debugline           435
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      pushstring          "effectEditorCancel"
      callpropvoid        QName(PackageNamespace(""), "_-6AK"), 1

      debugline           436
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "dispose"), 0

      debugline           437
      jump                L138

L40:
      label
      debugline           439
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "dispose"), 0

      debugline           440
      jump                L138

L46:
      label
      debugline           442
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5dD")
      getproperty         QName(PackageNamespace(""), "component")
      getproperty         QName(PackageNamespace(""), "context")
      pushstring          "habbopages/camera"
      callpropvoid        QName(Namespace("_-s9"), "createLinkEvent"), 1

      debugline           443
      jump                L138

L56:
      label
      debugline           446
      jump                L138

L59:
      label
      debugline           449
      jump                L138

L62:
      label
      debugline           451
      getlocal0
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5b4")
      not
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5b4")

      debugline           452
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2H6"), 0

      debugline           453
      jump                L138

L74:
      label
      debugline           455
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callpropvoid        QName(PackageNamespace(""), "disable"), 0

      debugline           456
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      pushnull
      ifeq                L89

      debugline           457
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      callpropvoid        QName(PackageNamespace(""), "_-5ib"), 0

      debugline           459
L89:
      jump                L138

      jump                L138

      debugline           433
L92:
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      setlocal3

      pushstring          "cancel_button"
      debugline           434
      getlocal3
      ifstrictne          L101

      pushbyte            0
      jump                L135

L101:
      pushstring          "header_button_close"
      debugline           438
      getlocal3
      ifstrictne          L107

      pushbyte            1
      jump                L135

L107:
      pushstring          "help_button"
      debugline           441
      getlocal3
      ifstrictne          L113

      pushbyte            2
      jump                L135

L113:
      pushstring          "save_button"
      debugline           444
      getlocal3
      ifstrictne          L119

      pushbyte            3
      jump                L135

L119:
      pushstring          "slider_container"
      debugline           447
      getlocal3
      ifstrictne          L125

      pushbyte            4
      jump                L135

L125:
      pushstring          "zoom_button"
      debugline           450
      getlocal3
      ifstrictne          L131

      pushbyte            5
      jump                L135

L131:
      jump                L134

      pushbyte            6
      jump                L135

L134:
      pushbyte            6
L135:
      kill                3
      lookupswitch        L74, [L29, L40, L46, L56, L59, L62, L74]

      debugline           462
L138:
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      pushstring          "typebutton"
      callproperty        QName(Namespace("http://adobe.com/AS3/2006/builtin"), "indexOf"), 1
      pushbyte            255
      ifeq                L154

      debugline           463
      getlocal0
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      pushstring          ","
      callproperty        QName(Namespace("http://adobe.com/AS3/2006/builtin"), "split"), 1
      pushbyte            1
      getproperty         MultinameL([PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6Ys"), 1

      debugline           465
L154:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-65e")
   method
    refid "_-3XF:CameraPhotoLab/_-65e"
    param QName(PackageNamespace("_-3XF"), "CameraEffect")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           467
      getlocal0
      pushscope

      debug               1, "k", 0, 467
      debugline           468
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      pushnull
      ifeq                L15

      debugline           469
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      callpropvoid        QName(PackageNamespace(""), "_-5ib"), 0

      debugline           471
L15:
      getlocal0
      getlocal1
      initproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")

      debugline           472
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      pushtrue
      callpropvoid        QName(PackageNamespace(""), "_-32s"), 1

      debugline           474
      getlocal1
      callproperty        QName(PackageNamespace(""), "_-3mu"), 0
      iffalse             L42

      debugline           475
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callpropvoid        QName(PackageNamespace(""), "enable"), 0

      debugline           476
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      getlocal1
      getproperty         QName(PackageNamespace(""), "value")
      callpropvoid        QName(PackageNamespace(""), "_-1xo"), 1

      debugline           477
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-07d"), 0

      jump                L46

      debugline           479
L42:
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-33U")
      callpropvoid        QName(PackageNamespace(""), "disable"), 0

      debugline           482
L46:
      getlocal1
      callproperty        QName(PackageNamespace(""), "_-3g"), 0
      iffalse             L54

      debugline           483
      getlocal0
      getlocal1
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-570"), 1

      debugline           486
L54:
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2H6"), 0

      debugline           487
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-570")
   method
    refid "_-3XF:CameraPhotoLab/_-570"
    param QName(PackageNamespace("_-3XF"), "CameraEffect")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 5
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           489
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal2

      debug               1, "k", 0, 489
      debug               1, "k", 1, 490
      debugline           490
      pushbyte            0
      setlocal3

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal            4

      jump                L42

L17:
      label
      getlocal            4
      getlocal3
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal2

      debugline           491
      getlocal2
      getproperty         QName(PackageNamespace(""), "type")
      getlocal1
      getproperty         QName(PackageNamespace(""), "type")
      equals
      dup
      iffalse             L36

      pop
      getlocal2
      getlocal1
      equals
      not
L36:
      iffalse             L42

      debugline           492
      getlocal2
      pushfalse
      callpropvoid        QName(PackageNamespace(""), "_-32s"), 1

      debugline           490
L42:
      hasnext2            4, 3
      iftrue              L17

      kill                4
      kill                3
      debugline           495
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6Ys")
   method
    refid "_-3XF:CameraPhotoLab/_-6Ys"
    param QName(PackageNamespace(""), "String")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 5
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           497
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal2

      debug               1, "k", 0, 497
      debug               1, "k", 1, 503
      debugline           498
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      pushnull
      ifeq                L19

      debugline           499
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-270")
      callpropvoid        QName(PackageNamespace(""), "_-5ib"), 0

      debugline           502
L19:
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc")
      callpropvoid        QName(Namespace("_-5Ga"), "_-2kf"), 0

      debugline           503
      pushbyte            0
      setlocal3

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal            4

      jump                L48

L30:
      label
      getlocal            4
      getlocal3
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal2

      debugline           504
      getlocal2
      getproperty         QName(PackageNamespace(""), "type")
      getlocal1
      ifne                L48

      debugline           505
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-0kc")
      getlocal2
      getproperty         QName(PackageNamespace(""), "button")
      callpropvoid        QName(Namespace("_-5Ga"), "_-3kr"), 1

      debugline           503
L48:
      hasnext2            4, 3
      iftrue              L30

      kill                4
      kill                3
      debugline           508
      getlocal0
      getlocal1
      callpropvoid        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5HJ"), 1

      debugline           509
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5HJ")
   method
    refid "_-3XF:CameraPhotoLab/_-5HJ"
    param QName(PackageNamespace(""), "String")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 4
     localcount 6
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           511
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal2

      pushnull
      coerce              QName(PackageNamespace("_-X3"), "IWindow")
      setlocal3

      debug               1, "k", 0, 511
      debug               1, "k", 1, 512
      debugline           512
      pushbyte            0
      setlocal            4

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2S9")
      coerce_a
      setlocal            5

      jump                L43

L20:
      label
      getlocal            5
      getlocal            4
      nextvalue
      coerce              QName(PackageNamespace("_-X3"), "IWindowContainer")
      setlocal2

      debug               1, "k", 2, 513
      debugline           513
      getlocal2
      pushstring          "active_border"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      coerce              QName(PackageNamespace("_-X3"), "IWindow")
      setlocal3

      debugline           514
      getlocal3
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      pushstring          "typebutton,"
      getlocal1
      add
      equals
      setproperty         QName(Namespace("_-6q"), "visible")

      debugline           512
L43:
      hasnext2            5, 4
      iftrue              L20

      kill                5
      kill                4
      debugline           516
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-2H6")
   method
    refid "_-3XF:CameraPhotoLab/_-2H6"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 6
     localcount 9
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           518
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("flash.geom"), "ColorTransform")
      setlocal1

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal3

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal            4

      pushnull
      coerce              QName(PackageNamespace("flash.geom"), "Matrix")
      setlocal            5

      pushnull
      coerce              QName(PackageNamespace("flash.display"), "BitmapData")
      setlocal            6

      debug               1, "k", 0, 519
      debug               1, "k", 1, 520
      debug               1, "k", 2, 533
      debug               1, "k", 3, 545
      debugline           520
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6FI")
      callproperty        QName(PackageNamespace(""), "clone"), 0
      coerce              QName(PackageNamespace("flash.display"), "BitmapData")
      setlocal2

      debugline           522
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5b4")
      iffalse             L83

      debug               1, "k", 4, 523
      debug               1, "k", 5, 528
      debugline           523
      findpropstrict      QName(PackageNamespace("flash.geom"), "Matrix")
      constructprop       QName(PackageNamespace("flash.geom"), "Matrix"), 0
      coerce              QName(PackageNamespace("flash.geom"), "Matrix")
      setlocal            5

      debugline           524
      getlocal            5
      pushbyte            2
      setproperty         QName(PackageNamespace(""), "a")

      debugline           525
      getlocal            5
      pushbyte            2
      setproperty         QName(PackageNamespace(""), "d")

      debugline           526
      getlocal            5
      getlocal2
      getproperty         QName(PackageNamespace(""), "width")
      negate
      pushbyte            2
      divide
      setproperty         QName(PackageNamespace(""), "tx")

      debugline           527
      getlocal            5
      getlocal2
      getproperty         QName(PackageNamespace(""), "height")
      negate
      pushbyte            2
      divide
      setproperty         QName(PackageNamespace(""), "ty")

      debugline           528
      findpropstrict      QName(PackageNamespace("flash.display"), "BitmapData")
      getlocal2
      getproperty         QName(PackageNamespace(""), "width")
      getlocal2
      getproperty         QName(PackageNamespace(""), "height")
      constructprop       QName(PackageNamespace("flash.display"), "BitmapData"), 2
      coerce              QName(PackageNamespace("flash.display"), "BitmapData")
      setlocal            6

      debugline           529
      getlocal            6
      getlocal2
      getlocal            5
      callpropvoid        QName(PackageNamespace(""), "draw"), 2

      debugline           530
      getlocal            6
      coerce              QName(PackageNamespace("flash.display"), "BitmapData")
      setlocal2

      debugline           533
L83:
      pushbyte            0
      setlocal            7

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal            8

      jump                L146

L90:
      label
      getlocal            8
      getlocal            7
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal3

      debugline           534
      getlocal3
      getproperty         QName(PackageNamespace(""), "_-36j")
      iffalse             L146

      debugline           535
      getlocal3
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-3FF")
      ifne                L119

      debugline           536
      getlocal2
      getlocal2
      getlocal2
      getproperty         QName(PackageNamespace(""), "rect")
      findpropstrict      QName(PackageNamespace("flash.geom"), "Point")
      pushbyte            0
      dup
      constructprop       QName(PackageNamespace("flash.geom"), "Point"), 2
      getlocal3
      callproperty        QName(PackageNamespace(""), "_-6Dt"), 0
      callpropvoid        QName(PackageNamespace(""), "applyFilter"), 4

      debugline           538
L119:
      getlocal3
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-4m-")
      ifne                L146

      debugline           539
      findpropstrict      QName(PackageNamespace("flash.geom"), "ColorTransform")
      pushbyte            1
      dup
      dup
      getlocal3
      callproperty        QName(PackageNamespace(""), "_-1uf"), 0
      constructprop       QName(PackageNamespace("flash.geom"), "ColorTransform"), 4
      coerce              QName(PackageNamespace("flash.geom"), "ColorTransform")
      setlocal1

      debugline           540
      getlocal2
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      getlocal3
      getproperty         QName(PackageNamespace(""), "name")
      callproperty        QName(PackageNamespace(""), "getImage"), 1
      pushnull
      getlocal1
      getlocal3
      getproperty         QName(PackageNamespace(""), "_-3bl")
      callpropvoid        QName(PackageNamespace(""), "draw"), 4

      debugline           533
L146:
      hasnext2            8, 7
      iftrue              L90

      kill                8
      kill                7
      debugline           545
      pushbyte            0
      setlocal            7

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal            8

      jump                L185

L158:
      label
      getlocal            8
      getlocal            7
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal            4

      debugline           546
      getlocal            4
      getproperty         QName(PackageNamespace(""), "_-36j")
      convert_b
      dup
      iffalse             L176

      pop
      getlocal            4
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-2N1")
      equals
L176:
      iffalse             L185

      debugline           547
      getlocal2
      getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
      getlocal            4
      getproperty         QName(PackageNamespace(""), "name")
      callproperty        QName(PackageNamespace(""), "getImage"), 1
      callpropvoid        QName(PackageNamespace(""), "draw"), 1

      debugline           545
L185:
      hasnext2            8, 7
      iftrue              L158

      kill                8
      kill                7
      debugline           550
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")
      getlocal2
      setproperty         QName(Namespace("_-5Rl"), "bitmap")

      debugline           551
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3um")
      callpropvoid        QName(Namespace("_-6q"), "invalidate"), 0

      debugline           552
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(ProtectedNamespace("_-4E0"), "_-5ob")
   method
    refid "_-3XF:CameraPhotoLab/_-4E0:_-5ob"
    param QName(PackageNamespace("_-CA"), "WindowMouseEvent")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 1
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           554
      getlocal0
      pushscope

      debug               1, "k", 0, 554
      debugline           555
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "dispose"), 0

      debugline           556
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-1ub")
   method
    refid "_-3XF:CameraPhotoLab/_-1ub"
    param QName(PackageNamespace(""), "String")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           558
      getlocal0
      pushscope

      debug               1, "k", 0, 558
      debugline           559
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      iffalse             L13

      debugline           560
      getlex              QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO")
      getlocal1
      callpropvoid        QName(PackageNamespace(""), "_-2OM"), 1

      debugline           562
L13:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-302")
   method
    refid "_-3XF:CameraPhotoLab/_-302"
    returns QName(PackageNamespace(""), "String")
    body
     maxstack 4
     localcount 7
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           564
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace(""), "Object")
      setlocal2

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal3

      pushnull
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal            4

      debug               1, "k", 0, 565
      debug               1, "k", 1, 566
      debug               1, "k", 2, 567
      debug               1, "k", 3, 576
      debugline           565
      getlex              Multiname("Vector", [PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0"), PackageNamespace("__AS3__.vec")])
      getlex              QName(PackageNamespace(""), "Object")
      applytype           1
      construct           0
      coerce              TypeName(QName(PackageNamespace("__AS3__.vec"), "Vector")<QName(PackageNamespace(""), "Object")>)
      setlocal1

      debugline           567
      pushbyte            0
      setlocal            5

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal            6

      jump                L75

L32:
      label
      getlocal            6
      getlocal            5
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal3

      debugline           568
      getlocal3
      getproperty         QName(PackageNamespace(""), "_-36j")
      convert_b
      dup
      iffalse             L51

      pop
      getlocal3
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-2N1")
      equals
      not
L51:
      iffalse             L75

      debugline           569
      newobject           0
      coerce              QName(PackageNamespace(""), "Object")
      setlocal2

      debugline           570
      getlocal2
      getlocal3
      getproperty         QName(PackageNamespace(""), "name")
      setproperty         Multiname("name", [PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])

      debugline           571
      getlocal2
      findpropstrict      QName(PackageNamespace(""), "int")
      getlocal3
      callproperty        QName(PackageNamespace(""), "_-1uf"), 0
      pushshort           255
      multiply
      callproperty        QName(PackageNamespace(""), "int"), 1
      setproperty         Multiname("alpha", [PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])

      debugline           572
      getlocal1
      getlocal2
      callpropvoid        QName(Namespace("http://adobe.com/AS3/2006/builtin"), "push"), 1

      debugline           567
L75:
      hasnext2            6, 5
      iftrue              L32

      kill                6
      kill                5
      debugline           576
      pushbyte            0
      setlocal            5

      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-1yf")
      coerce_a
      setlocal            6

      jump                L120

L87:
      label
      getlocal            6
      getlocal            5
      nextvalue
      coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
      setlocal            4

      debugline           577
      getlocal            4
      getproperty         QName(PackageNamespace(""), "_-36j")
      convert_b
      dup
      iffalse             L105

      pop
      getlocal            4
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
      getproperty         QName(PackageNamespace(""), "_-2N1")
      equals
L105:
      iffalse             L120

      debugline           578
      newobject           0
      coerce              QName(PackageNamespace(""), "Object")
      setlocal2

      debugline           579
      getlocal2
      getlocal            4
      getproperty         QName(PackageNamespace(""), "name")
      setproperty         Multiname("name", [PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), PackageNamespace("_-3XF"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("CameraPhotoLab.as$4895", "_-3XF:CameraPhotoLab#1"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-4E0"), StaticProtectedNs("_-4E0")])

      debugline           580
      getlocal1
      getlocal2
      callpropvoid        QName(Namespace("http://adobe.com/AS3/2006/builtin"), "push"), 1

      debugline           576
L120:
      hasnext2            6, 5
      iftrue              L87

      kill                6
      kill                5
      debugline           584
      getlex              QName(PackageNamespace(""), "JSON")
      getlocal1
      callproperty        QName(PackageNamespace(""), "stringify"), 1
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-17i")
   method
    refid "_-3XF:CameraPhotoLab/_-17i"
    returns QName(PackageNamespace(""), "int")
    body
     maxstack 1
     localcount 1
     initscopedepth 4
     maxscopedepth 5
     code
      debugfile           "k"
      debugline           587
      getlocal0
      pushscope

      debugline           588
      getlocal0
      getproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-5b4")
      iffalse             L10

      pushbyte            2
      jump                L11

L10:
      pushbyte            1
L11:
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
 end ; instance
 cinit
  refid "_-3XF:CameraPhotoLab/cinit"
  body
   maxstack 2
   localcount 1
   initscopedepth 3
   maxscopedepth 4
   code
    getlocal0
    pushscope

    debug               1, "k", 0, 45
    findproperty        QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3sO")
    pushbyte            6
    setproperty         QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3sO")

    debug               1, "k", 1, 59
    returnvoid
   end ; code
  end ; body
 end ; method
 trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-3sO") slotid 1 type QName(PackageNamespace(""), "int") value Integer(6) end
 trait slot QName(PrivateNamespace("_-4E0", "_-3XF:CameraPhotoLab#0"), "_-6KO") slotid 2 type QName(PackageInternalNs("_-3XF"), "_-IC") end
 trait method QName(PackageNamespace(""), "_-30a") flag FINAL dispid 3
  method
   refid "_-3XF:CameraPhotoLab/_-30a"
   param QName(PackageNamespace(""), "String")
   param QName(PackageNamespace(""), "String")
   param QName(PackageNamespace("_-647"), "_-6kP")
   returns QName(PackageNamespace(""), "void")
   body
    maxstack 3
    localcount 9
    initscopedepth 3
    maxscopedepth 4
    code
     debugfile           "k"
     debugline           176
     getlocal0
     pushscope

     pushnull
     coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
     setlocal            6

     debug               1, "k", 0, 176
     debug               1, "k", 1, 176
     debug               1, "k", 2, 176
     debug               1, "k", 3, 179
     debug               1, "k", 4, 180
     debug               1, "k", 5, 181
     debugline           179
     newarray            0
     coerce              QName(PackageNamespace(""), "Array")
     setlocal            4

     debugline           180
     getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
     getlocal2
     getlocal3
     callproperty        QName(PackageNamespace(""), "_-2h0"), 2
     coerce              QName(PackageNamespace("_-07U"), "Map")
     setlocal            5

     debugline           181
     pushbyte            0
     setlocal            7

     getlocal            5
     coerce_a
     setlocal            8

     jump                L58

L31:
     label
     getlocal            8
     getlocal            7
     nextvalue
     coerce              QName(PackageNamespace("_-3XF"), "CameraEffect")
     setlocal            6

     debugline           182
     getlocal            6
     getproperty         QName(PackageNamespace(""), "type")
     getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
     getproperty         QName(PackageNamespace(""), "_-4m-")
     equals
     dup
     iftrue              L51

     pop
     getlocal            6
     getproperty         QName(PackageNamespace(""), "type")
     getlex              QName(PackageNamespace("_-3XF"), "CameraEffect")
     getproperty         QName(PackageNamespace(""), "_-2N1")
     equals
L51:
     iffalse             L58

     debugline           183
     getlocal            4
     getlocal            6
     getproperty         QName(PackageNamespace(""), "name")
     callpropvoid        QName(Namespace("http://adobe.com/AS3/2006/builtin"), "push"), 1

     debugline           181
L58:
     hasnext2            8, 7
     iftrue              L31

     kill                8
     kill                7
     debugline           186
     getlex              QName(PackageNamespace("_-3XF"), "CameraFxPreloader")
     getlocal1
     getlocal            4
     callpropvoid        QName(PackageNamespace(""), "init"), 2

     debugline           187
     returnvoid
    end ; code
   end ; body
  end ; method
 end ; trait
end ; class
';

//RoomThumbnailCameraWidget.class.asasm
$RoomThumbnailCameraWidget='class
 refid "_-3XF:RoomThumbnailCameraWidget"
 instance QName(PackageNamespace("_-3XF"), "RoomThumbnailCameraWidget")
  extends QName(PackageNamespace("_-4u8"), "_-0hZ")
  implements Multiname("_-wE", [PackageNamespace("_-1M6")])
  implements Multiname("_-2YF", [PackageNamespace("_-1dC")])
  flag SEALED
  flag PROTECTEDNS
  protectedns ProtectedNamespace("_-5Eq")
  iinit
   refid "_-3XF:RoomThumbnailCameraWidget/iinit"
   param QName(PackageNamespace("_-5yk"), "_-3JI")
   param QName(PackageNamespace("_-01n"), "_-8m")
   param QName(PackageNamespace("_-eg"), "_-6Pl")
   param QName(PackageNamespace("_-1M6"), "_-4Mc")
   param QName(PackageNamespace("_-647"), "_-6kP")
   param QName(PackageNamespace("_-5yk"), "RoomUI")
   body
    maxstack 5
    localcount 7
    initscopedepth 5
    maxscopedepth 6
    code
     debugfile           "k"
     debugline           43
     getlocal0
     pushscope

     debug               1, "k", 0, 43
     debug               1, "k", 1, 43
     debug               1, "k", 2, 43
     debug               1, "k", 3, 43
     debug               1, "k", 4, 43
     debug               1, "k", 5, 43
     debugline           44
     getlocal0
     getlocal1
     getlocal2
     getlocal3
     getlocal            5
     constructsuper      4

     debugline           46
     getlocal0
     getlocal            6
     initproperty        QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-1vK")

     debugline           47
     getlocal0
     getproperty         QName(PackageNamespace(""), "handler")
     getlocal0
     setproperty         QName(PackageNamespace(""), "widget")

     debugline           48
     getlocal0
     getproperty         QName(PackageNamespace(""), "roomEngine")
     iffalse             L49

     debugline           49
     getlocal0
     getproperty         QName(PackageNamespace(""), "roomEngine")
     getproperty         QName(Namespace("_-5e-"), "events")
     getlex              QName(PackageNamespace("_-4mE"), "_-47W")
     getproperty         QName(PackageNamespace(""), "_-3j6")
     getlocal0
     getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-2H9")
     callpropvoid        QName(Namespace("flash.events:IEventDispatcher"), "addEventListener"), 2

     debugline           50
     getlocal0
     getproperty         QName(PackageNamespace(""), "roomEngine")
     getproperty         QName(Namespace("_-5e-"), "events")
     getlex              QName(PackageNamespace("_-4mE"), "_-47W")
     getproperty         QName(PackageNamespace(""), "_-5Nf")
     getlocal0
     getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-34W")
     callpropvoid        QName(Namespace("flash.events:IEventDispatcher"), "addEventListener"), 2

     debugline           52
L49:
     getlocal2
     getlex              QName(PackageNamespace("_-1M6"), "Component")
     astypelate
     getproperty         QName(PackageNamespace(""), "context")
     getlocal0
     callpropvoid        QName(Namespace("_-s9"), "addLinkEventTracker"), 1

     debugline           53
     returnvoid
    end ; code
   end ; body
  end ; method
  trait slot QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-1vK") type QName(PackageNamespace("_-5yk"), "RoomUI") end
  trait slot QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi") type QName(PackageNamespace("_-1Bv"), "IFrameWindow") value Null() end
  trait slot QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um") type QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow") end
  trait method QName(PackageNamespace(""), "dispose") flag OVERRIDE
   method
    refid "_-3XF:RoomThumbnailCameraWidget/dispose"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           55
      getlocal0
      pushscope

      debugline           56
      getlex              QName(PackageNamespace(""), "disposed")
      iffalse             L10

      debugline           57
      returnvoid

      debugline           59
L10:
      getlex              QName(PackageNamespace(""), "windowManager")
      getlex              QName(PackageNamespace("_-1M6"), "Component")
      astypelate
      getproperty         QName(PackageNamespace(""), "context")
      getlocal0
      callpropvoid        QName(Namespace("_-s9"), "removeLinkEventTracker"), 1

      debugline           60
      getlocal0
      callsupervoid       QName(PackageNamespace(""), "dispose"), 0
      debugline           61
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait getter QName(PackageNamespace(""), "container")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/container/getter"
    returns QName(PackageNamespace("_-5yk"), "_-6G7")
    body
     maxstack 1
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           63
      getlocal0
      pushscope

      debugline           64
      getlocal0
      getproperty         QName(PackageNamespace(""), "handler")
      iffalse             L13

      getlocal0
      getproperty         QName(PackageNamespace(""), "handler")
      getproperty         QName(PackageNamespace(""), "container")
      coerce              QName(PackageNamespace("_-5yk"), "_-6G7")
      jump                L15

L13:
      pushnull
      coerce              QName(PackageNamespace("_-5yk"), "_-6G7")
L15:
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait getter QName(PackageNamespace(""), "handler")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/handler/getter"
    returns QName(PackageNamespace("_-35o"), "_-5D2")
    body
     maxstack 2
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           67
      getlocal0
      pushscope

      debugline           68
      getlex              QName(ProtectedNamespace("include"), "_-26B")
      getlex              QName(PackageNamespace("_-35o"), "_-5D2")
      astypelate
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait getter QName(PackageNamespace(""), "roomEngine")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/roomEngine/getter"
    returns QName(PackageNamespace("_-1KZ"), "_-1DI")
    body
     maxstack 1
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           71
      getlocal0
      pushscope

      debugline           72
      getlocal0
      getproperty         QName(PackageNamespace(""), "container")
      iffalse             L13

      getlocal0
      getproperty         QName(PackageNamespace(""), "container")
      getproperty         QName(Namespace("_-6cm"), "roomEngine")
      coerce              QName(PackageNamespace("_-1KZ"), "_-1DI")
      jump                L15

L13:
      pushnull
      coerce              QName(PackageNamespace("_-1KZ"), "_-1DI")
L15:
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "update")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/update"
    param QName(PackageNamespace(""), "uint")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 6
     localcount 5
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           75
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("flash.geom"), "Point")
      setlocal2

      pushnull
      coerce              QName(PackageNamespace("flash.geom"), "Matrix")
      setlocal3

      pushnull
      coerce              QName(PackageNamespace("_-5u3"), "_-26U")
      setlocal            4

      debug               1, "k", 0, 75
      debugline           76
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      convert_b
      dup
      iffalse             L24

      pop
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      convert_b
L24:
      iffalse             L112

      debug               1, "k", 1, 82
      debug               1, "k", 2, 84
      debug               1, "k", 3, 87
      debugline           77
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      pushnull
      ifne                L49

      debugline           78
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      findpropstrict      QName(PackageNamespace("flash.display"), "BitmapData")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-6q"), "height")
      pushfalse
      pushbyte            0
      constructprop       QName(PackageNamespace("flash.display"), "BitmapData"), 4
      setproperty         QName(Namespace("_-5Rl"), "bitmap")

      debugline           80
L49:
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      getproperty         QName(PackageNamespace(""), "rect")
      getlocal0
      getproperty         QName(PackageNamespace(""), "handler")
      getproperty         QName(PackageNamespace(""), "_-2WV")
      getproperty         QName(PackageNamespace(""), "_-3Kz")
      callpropvoid        QName(PackageNamespace(""), "fillRect"), 2

      debugline           82
      findpropstrict      QName(PackageNamespace("flash.geom"), "Point")
      pushbyte            0
      dup
      constructprop       QName(PackageNamespace("flash.geom"), "Point"), 2
      coerce              QName(PackageNamespace("flash.geom"), "Point")
      setlocal2

      debugline           83
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getlocal2
      callpropvoid        QName(Namespace("_-6q"), "getGlobalPosition"), 1

      debugline           84
      findpropstrict      QName(PackageNamespace("flash.geom"), "Matrix")
      constructprop       QName(PackageNamespace("flash.geom"), "Matrix"), 0
      coerce              QName(PackageNamespace("flash.geom"), "Matrix")
      setlocal3

      debugline           85
      getlocal3
      getlocal2
      getproperty         QName(PackageNamespace(""), "x")
      negate
      getlocal2
      getproperty         QName(PackageNamespace(""), "y")
      negate
      callpropvoid        QName(PackageNamespace(""), "translate"), 2

      debugline           87
      getlocal0
      getproperty         QName(PackageNamespace(""), "container")
      getproperty         QName(Namespace("_-6cm"), "roomSession")
      coerce              QName(PackageNamespace("_-5u3"), "_-26U")
      setlocal            4

      debugline           88
      getlocal0
      getproperty         QName(PackageNamespace(""), "roomEngine")
      getlocal            4
      getproperty         QName(Namespace("_-5NU"), "roomId")
      getlocal0
      getproperty         QName(PackageNamespace(""), "container")
      callproperty        QName(Namespace("_-6cm"), "getFirstCanvasId"), 0
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      getlocal3
      pushfalse
      callpropvoid        QName(Namespace("_-5e-"), "_-4bv"), 5

      debugline           89
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      callpropvoid        QName(Namespace("_-6q"), "invalidate"), 0

      debugline           91
L112:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-6AK")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-6AK"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 5
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           93
      getlocal0
      pushscope

      debugline           94
      getlocal0
      getproperty         QName(PackageNamespace(""), "roomEngine")
      convert_b
      dup
      iffalse             L17

      pop
      getlocal0
      getproperty         QName(PackageNamespace(""), "roomEngine")
      callproperty        QName(Namespace("_-5e-"), "_-1Bi"), 0
      pushbyte            1
      equals
      not
L17:
      iffalse             L28

      debugline           95
      getlex              QName(PackageNamespace(""), "windowManager")
      pushstring          "Camera only works on normal zoom!"
      pushstring          "Return to normal zoom level and try again!"
      pushbyte            0
      pushnull
      callpropvoid        QName(Namespace("_-4hF"), "alert"), 4

      debugline           96
      returnvoid

      debugline           98
L28:
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      iftrue              L35

      debugline           99
      getlocal0
      callpropvoid        QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "createWindow"), 0

      debugline           101
L35:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "createWindow")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/createWindow"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 6
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           103
      getlocal0
      pushscope

      debugline           104
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      iffalse             L11

      getlocal0
      callpropvoid        QName(PackageNamespace(""), "destroy"), 0

      debugline           105
L11:
      getlocal0
      findpropstrict      QName(PackageNamespace("_-1Bv"), "IFrameWindow")
      getlex              QName(PackageNamespace(""), "windowManager")
      findpropstrict      QName(PackageNamespace(""), "XML")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-1vK")
      getproperty         QName(PackageNamespace(""), "assets")
      pushstring          "iro_room_thumbnail_camera_xml"
      callproperty        QName(Namespace("_-0LM"), "getAssetByName"), 1
      getproperty         QName(Namespace("_-6i0"), "content")
      callproperty        QName(PackageNamespace(""), "XML"), 1
      callproperty        QName(Namespace("_-1lf"), "buildFromXML"), 1
      callproperty        QName(PackageNamespace("_-1Bv"), "IFrameWindow"), 1
      initproperty        QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")

      debugline           106
      getlocal0
      findpropstrict      QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      pushstring          "viewfinder"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callproperty        QName(PackageNamespace("_-1Bv"), "IBitmapWrapperWindow"), 1
      initproperty        QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")

      debugline           107
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-12r")
      setproperty         QName(Namespace("_-6q"), "procedure")

      debugline           108
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      callpropvoid        QName(Namespace("_-6q"), "center"), 0

      debugline           109
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-1vK")
      getlocal0
      pushbyte            10
      callpropvoid        QName(PackageNamespace(""), "registerUpdateReceiver"), 2

      debugline           110
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "destroy")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/destroy"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           112
      getlocal0
      pushscope

      debugline           113
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      iffalse             L22

      debugline           114
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      callpropvoid        QName(Namespace("_-6q"), "destroy"), 0

      debugline           115
      getlocal0
      pushnull
      initproperty        QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")

      debugline           116
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-1vK")
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "removeUpdateReceiver"), 1

      debugline           118
L22:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait getter QName(PackageNamespace(""), "_-0rQ")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-0rQ/getter"
    returns QName(PackageNamespace("flash.geom"), "Rectangle")
    body
     maxstack 5
     localcount 2
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           120
      getlocal0
      pushscope

      debug               1, "k", 0, 121
      debugline           121
      findpropstrict      QName(PackageNamespace("flash.geom"), "Point")
      pushbyte            0
      dup
      constructprop       QName(PackageNamespace("flash.geom"), "Point"), 2
      coerce              QName(PackageNamespace("flash.geom"), "Point")
      setlocal1

      debugline           122
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getlocal1
      callpropvoid        QName(Namespace("_-6q"), "getGlobalPosition"), 1

      debugline           123
      findpropstrict      QName(PackageNamespace("flash.geom"), "Rectangle")
      getlocal1
      getproperty         QName(PackageNamespace(""), "x")
      getlocal1
      getproperty         QName(PackageNamespace(""), "y")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-6q"), "width")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-6q"), "height")
      constructprop       QName(PackageNamespace("flash.geom"), "Rectangle"), 4
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-2H9")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-2H9"
    param QName(PackageNamespace("_-4mE"), "_-47W")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 1
     localcount 2
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           126
      getlocal0
      pushscope

      debug               1, "k", 0, 126
      debugline           127
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "destroy"), 0

      debugline           128
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-34W")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-34W"
    param QName(PackageNamespace("_-4mE"), "_-47W")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 2
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           130
      getlocal0
      pushscope

      debug               1, "k", 0, 130
      debugline           131
      getlocal0
      getproperty         QName(PackageNamespace(""), "roomEngine")
      convert_b
      dup
      iffalse             L18

      pop
      getlocal0
      getproperty         QName(PackageNamespace(""), "roomEngine")
      callproperty        QName(Namespace("_-5e-"), "_-1Bi"), 0
      pushbyte            1
      equals
      not
L18:
      iffalse             L22

      getlocal0
      callpropvoid        QName(PackageNamespace(""), "destroy"), 0

      debugline           132
L22:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-1Sh")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-1Sh"
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           134
      getlocal0
      pushscope

      debugline           135
      getlocal0
      getproperty         QName(PackageNamespace(""), "container")
      getproperty         QName(Namespace("_-6cm"), "_-1OF")
      getlex              QName(PackageNamespace("_-4q5"), "_-lL")
      getproperty         QName(PackageNamespace(""), "_-6YP")
      callpropvoid        QName(Namespace("_-cV"), "_-13b"), 1

      debugline           136
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-12r")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-12r"
    param QName(PackageNamespace("_-CA"), "WindowEvent")
    param QName(PackageNamespace("_-X3"), "IWindow")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 20
     localcount 9
     initscopedepth 5
     maxscopedepth 20
     code
      debugfile           "k"
      debugline           138
      getlocal0
      pushscope

      pushnull
      coerce              QName(PackageNamespace("_-DN"), "_-1fR")
      setlocal            4

      debug               1, "k", 0, 138
      debug               1, "k", 1, 138
      debug               1, "k", 2, 139
      debugline           139
      getlocal1
      getlex              QName(PackageNamespace("_-CA"), "WindowMouseEvent")
      astypelate
      coerce              QName(PackageNamespace("_-CA"), "WindowMouseEvent")
      setlocal3

      debugline           140
      getlocal3
      convert_b
      dup
      iffalse             L27

      pop
      getlocal3
      getproperty         QName(PackageNamespace(""), "type")
      getlex              QName(PackageNamespace("_-CA"), "WindowMouseEvent")
      getproperty         QName(PackageNamespace(""), "CLICK")
      equals
L27:
      iffalse             L152

      jump                L124

      debug               1, "k", 3, 144
L30:
      label
      debugline           143
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "_-1Sh"), 0

      debugline           144
      findpropstrict      QName(PackageNamespace("_-35o"), "_-5D2")
      getlocal0
      getproperty         QName(PackageNamespace(""), "handler")
      callproperty        QName(PackageNamespace("_-35o"), "_-5D2"), 1
      callproperty        QName(PackageNamespace(""), "_-2kd"), 0
      coerce              QName(PackageNamespace("_-DN"), "_-1fR")
      setlocal            4

      debugline           145
      getlocal            4
      pushnull
      equals
      not
      dup
      iffalse             L53

      pop
      getlocal            4
      callproperty        QName(PackageNamespace(""), "_-5El"), 0
      convert_b
L53:
      iffalse             L107

      debugline           146
      getlocal0
      getproperty         QName(PackageNamespace(""), "handler")
      getlocal            4
      callpropvoid        QName(PackageNamespace(""), "_-3cF"), 1

      debugline           147
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      pushstring          "button_capture"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callpropvoid        QName(Namespace("_-6q"), "disable"), 0

      debugline           148
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-Fi")
      pushstring          "button_cancel"
      callproperty        QName(Namespace("_-3si"), "findChildByName"), 1
      callpropvoid        QName(Namespace("_-6q"), "disable"), 0

      debugline           149
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-1vK")
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "removeUpdateReceiver"), 1

      findpropstrict      QName(PackageNamespace("flash.net"), "URLRequest")
      pushstring          "'.$_GET['http'].'://'.$_GET['linkhotel'].'/camera/thumbnails/index.php?roomid="
      getlocal            4
      callproperty        QName(PackageNamespace(""), "getRoomId"), 0
      add
      constructprop       QName(PackageNamespace("flash.net"), "URLRequest"), 1
      coerce              QName(PackageNamespace("flash.net"), "URLRequest")
      setlocal            5

      getlocal            5
      getlex              QName(PackageNamespace("_-04A"), "PNGEncoder")
      getlocal0
      getproperty         QName(PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), "_-3um")
      getproperty         QName(Namespace("_-5Rl"), "bitmap")
      callproperty        QName(PackageNamespace(""), "encode"), 1
      setproperty         QName(PackageNamespace(""), "data")

      getlocal            5
      pushstring          "application/octet-stream"
      setproperty         QName(PackageNamespace(""), "contentType")

      getlocal            5
      getlex              QName(PackageNamespace("flash.net"), "URLRequestMethod")
      getproperty         QName(PackageNamespace(""), "POST")
      setproperty         QName(PackageNamespace(""), "method")

      findpropstrict      QName(PackageNamespace("flash.net"), "URLLoader")
      constructprop       QName(PackageNamespace("flash.net"), "URLLoader"), 0
      coerce              QName(PackageNamespace("flash.net"), "URLLoader")
      setlocal            6

      getlocal            6
      getlocal            5
      callpropvoid        QName(PackageNamespace(""), "load"), 1

      jump                L114

      debugline           151
L107:
      getlex              QName(PackageNamespace(""), "windowManager")
      pushstring          "${generic.alert.title}"
      pushstring          "${camera.alert.too_much_stuff}"
      pushbyte            0
      pushnull
      callpropvoid        QName(Namespace("_-4hF"), "alert"), 4

      debugline           153
L114:
      returnvoid

L115:
      label
      debugline           156
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "destroy"), 0

      debugline           158
      jump                L152

L121:
      label
      jump                L152

      debugline           141
L124:
      getlocal2
      getproperty         QName(Namespace("_-6q"), "name")
      setlocal            5

      pushstring          "button_capture"
      debugline           142
      getlocal            5
      ifstrictne          L133

      pushbyte            0
      jump                L149

L133:
      pushstring          "header_button_close"
      debugline           154
      getlocal            5
      ifstrictne          L139

      pushbyte            1
      jump                L149

L139:
      pushstring          "button_cancel"
      debugline           155
      getlocal            5
      ifstrictne          L145

      pushbyte            2
      jump                L149

L145:
      jump                L148

      pushbyte            3
      jump                L148

L148:
      pushbyte            3
L149:
      kill                5
      lookupswitch        L121, [L30, L115, L115, L121]

      debugline           161
L152:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
  trait getter QName(PackageNamespace(""), "_-01A")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-01A/getter"
    returns QName(PackageNamespace(""), "String")
    body
     maxstack 1
     localcount 1
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           163
      getlocal0
      pushscope

      pushstring          "roomThumbnailCamera"
      debugline           164
      returnvalue
     end ; code
    end ; body
   end ; method
  end ; trait
  trait method QName(PackageNamespace(""), "_-0Yu")
   method
    refid "_-3XF:RoomThumbnailCameraWidget/_-0Yu"
    param QName(PackageNamespace(""), "String")
    returns QName(PackageNamespace(""), "void")
    body
     maxstack 2
     localcount 4
     initscopedepth 5
     maxscopedepth 6
     code
      debugfile           "k"
      debugline           167
      getlocal0
      pushscope

      debug               1, "k", 0, 167
      debug               1, "k", 1, 168
      debug               1, "k", 2, 169
      debugline           168
      getlocal1
      pushstring          "/"
      callproperty        QName(Namespace("http://adobe.com/AS3/2006/builtin"), "split"), 1
      coerce              QName(PackageNamespace(""), "Array")
      setlocal2

      debugline           169
      getlocal2
      getproperty         QName(PackageNamespace(""), "length")
      convert_i
      setlocal3

      debugline           170
      getlocal3
      pushbyte            2
      ifnlt               L25

      debugline           171
      returnvoid

      debugline           174
L25:
      getlocal2
      pushbyte            1
      getproperty         MultinameL([PrivateNamespace("_-5Eq", "_-3XF:RoomThumbnailCameraWidget"), PackageNamespace(""), Namespace("http://adobe.com/AS3/2006/builtin"), PrivateNamespace("RoomThumbnailCameraWidget.as$4713", "_-3XF:RoomThumbnailCameraWidget/_-0Yu"), PackageNamespace("_-3XF"), PackageInternalNs("_-3XF"), ProtectedNamespace("_-5Eq"), StaticProtectedNs("_-5Eq"), StaticProtectedNs("include")])
      pushstring          "open"
      ifne                L34

      debugline           175
      getlocal0
      callpropvoid        QName(PackageNamespace(""), "_-6AK"), 0

      debugline           177
L34:
      returnvoid
     end ; code
    end ; body
   end ; method
  end ; trait
 end ; instance
 cinit
  refid "_-3XF:RoomThumbnailCameraWidget/cinit"
  body
   maxstack 1
   localcount 1
   initscopedepth 4
   maxscopedepth 5
   code
    getlocal0
    pushscope

    returnvoid
   end ; code
  end ; body
 end ; method
end ; class
';

$fp = fopen("..\galaxyservers\CompilaHabboSwf2\Habbo-2\_-3XF_\CameraPhotoLab.class.asasm", "w");
$escreve = fwrite($fp, $CameraPhotoLab);
fclose($fp);

$fp = fopen("..\galaxyservers\CompilaHabboSwf2\Habbo-2\_-3XF_\RoomThumbnailCameraWidget.class.asasm", "w");
$escreve = fwrite($fp, $RoomThumbnailCameraWidget);
fclose($fp);

$fp = fopen("..\galaxyservers\CompilaHabboSwf2/envia.php", "w");
$escreve = fwrite($fp, $GalaxyServersTxt);
fclose($fp);

$fp = fopen("..\galaxyservers\CompilaHabboSwf2\CompilaSWF.bat", "w");
$escreve = fwrite($fp, $GalaxyServersBat);
fclose($fp);

#endregion
?>