<?php
require_once ('../adminController.php');
include '../sessionController.php';
?>
<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->


<html lang="en">

<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>¿Quienes Somos?</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Creative Portfolio Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Kross Template v1.0">
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />

  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="../plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="../plugins/themify-icons/themify-icons.css">

  <!-- Main Stylesheet -->
  <link href="../css/style.css" rel="stylesheet">

</head>

<body>

  <header class="navigation fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand font-tertiary h3" title="Home" href="../index.php"><img src="../images/logo.png" alt="Home"
          style="height: 90px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse text-center" id="navigation">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="../index.php">Home</a>
          </li>
          <?php
          if ($isAdmin) {
            echo "<li class='nav-item'>
          <a class='nav-link' href='../admin-panel.php'>Panel de Administración</a>
          </li>";
          }

          if ($logged) {
            echo "<li class='nav-item'>
          <a class='nav-link' href='../logout.php'>Cerrar Sesión</a>
          </li>";
          } else {
            echo "<li class='nav-item'>
          <a class='nav-link' href='../login.php'>Iniciar Sesión</a>
          </li>";
          }
          ?>
          <li class="nav-item">
            <a class="btn btn-sm btn-success" href="<?php if ($logged) {
              echo "../create.php";
            } else {
              echo "../login.php";
            } ?>">Publica un Servicio</a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- page title -->
  <section class="page-title bg-primary position-relative">

    <!-- background shapes -->
    <img src="../images/illustrations/page-title.png" alt="illustrations" class="bg-shape-1 w-100">
    <img src="../images/illustrations/leaf-pink-round.png" alt="illustrations" class="bg-shape-2">
    <img src="../images/illustrations/leaf-orange.png" alt="illustrations" class="bg-shape-4">
    <img src="../images/illustrations/leaf-yellow.png" alt="illustrations" class="bg-shape-5">
    <img src="../images/illustrations/dots-group-cyan.png" alt="illustrations" class="bg-shape-6">
    <img src="../images/illustrations/leaf-cyan-lg.png" alt="illustrations" class="bg-shape-7">
  </section>
  <!-- /page title -->

  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="font-tertiary mb-3">AVISO LEGAL Y CONDICIONES GENERALES DE USO</h2>
          <div class="content">
            <h4>I. INFORMACIÓN GENERAL</h4>
            <p>En cumplimiento con el deber de información dispuesto en la Ley 34/2002 de Servicios de la Sociedad de la
              Información y el Comercio Electrónico (LSSI-CE) de 11 de julio, se facilitan a continuación los siguientes
              datos de información general de este sitio web:

              La titularidad de este sitio web, www.citytasks.com, (en adelante, Sitio Web) la ostenta: Sergio Pulido
              Salvador, con NIF: xxxxxxxx, y cuyos datos de contacto son:

              Dirección: Calle Ficticia 1

              Teléfono de contacto: 666 55 77 44

              Email de contacto: citytasks2024@gmail.com</p>

            <h4>II. TÉRMINOS Y CONDICIONES GENERALES DE USO</h4>
            <h5>El objeto de las condiciones: El Sitio Web</h5>
            <p>El objeto de las presentes Condiciones Generales de Uso (en adelante, Condiciones) es regular el acceso y
              la utilización del Sitio Web. A los efectos de las presentes Condiciones se entenderá como Sitio Web: la
              apariencia externa de los interfaces de pantalla, tanto de forma estática como de forma dinámica, es
              decir, el árbol de navegación; y todos los elementos integrados tanto en los interfaces de pantalla como
              en el árbol de navegación (en adelante, Contenidos) y todos aquellos servicios o recursos en línea que en
              su caso ofrezca a los Usuarios (en adelante, Servicios).

              CityTasks - Servicios de Barrio se reserva la facultad de modificar, en cualquier momento, y sin aviso
              previo, la presentación y configuración del Sitio Web y de los Contenidos y Servicios que en él pudieran
              estar incorporados. El Usuario reconoce y acepta que en cualquier momento CityTasks - Servicios de Barrio
              pueda interrumpir, desactivar y/o cancelar cualquiera de estos elementos que se integran en el Sitio Web o
              el acceso a los mismos.

              El acceso al Sitio Web por el Usuario tiene carácter libre y, por regla general, es gratuito sin que el
              Usuario tenga que proporcionar una contraprestación para poder disfrutar de ello, salvo en lo relativo al
              coste de conexión a través de la red de telecomunicaciones suministrada por el proveedor de acceso que
              hubiere contratado el Usuario.

              La utilización de alguno de los Contenidos o Servicios del Sitio Web podrá hacerse mediante la suscripción
              o registro previo del Usuario.</p>
            <h5>El Usuario</h5>
            <p>El acceso, la navegación y uso del Sitio Web, así como por los espacios habilitados para interactuar
              entre los Usuarios, y el Usuario y CityTasks - Servicios de Barrio, como los comentarios y/o espacios de
              blogging, confiere la condición de Usuario, por lo que se aceptan, desde que se inicia la navegación por
              el Sitio Web, todas las Condiciones aquí establecidas, así como sus ulteriores modificaciones, sin
              perjuicio de la aplicación de la correspondiente normativa legal de obligado cumplimiento según el caso.
              Dada la relevancia de lo anterior, se recomienda al Usuario leerlas cada vez que visite el Sitio Web.

              El Sitio Web de CityTasks - Servicios de Barrio proporciona gran diversidad de información, servicios y
              datos. El Usuario asume su responsabilidad para realizar un uso correcto del Sitio Web. Esta
              responsabilidad se extenderá a:

              Un uso de la información, Contenidos y/o Servicios y datos ofrecidos por CityTasks - Servicios de Barrio
              sin que sea contrario a lo dispuesto por las presentes Condiciones, la Ley, la moral o el orden público, o
              que de cualquier otro modo puedan suponer lesión de los derechos de terceros o del mismo funcionamiento
              del Sitio Web.
              La veracidad y licitud de las informaciones aportadas por el Usuario en los formularios extendidos por
              CityTasks - Servicios de Barrio para el acceso a ciertos Contenidos o Servicios ofrecidos por el Sitio
              Web. En todo caso, el Usuario notificará de forma inmediata a CityTasks - Servicios de Barrio acerca de
              cualquier hecho que permita el uso indebido de la información registrada en dichos formularios, tales
              como, pero no solo, el robo, extravío, o el acceso no autorizado a identificadores y/o contraseñas, con el
              fin de proceder a su inmediata cancelación.

              CityTasks - Servicios de Barrio se reserva el derecho de retirar todos aquellos comentarios y aportaciones
              que vulneren la ley, el respeto a la dignidad de la persona, que sean discriminatorios, xenófobos,
              racistas, pornográficos, spamming, que atenten contra la juventud o la infancia, el orden o la seguridad
              pública o que, a su juicio, no resultaran adecuados para su publicación.

              En cualquier caso, CityTasks - Servicios de Barrio no será responsable de las opiniones vertidas por los
              Usuarios a través de comentarios u otras herramientas de blogging o de participación que pueda haber.

              El mero acceso a este Sitio Web no supone entablar ningún tipo de relación de carácter comercial entre
              CityTasks - Servicios de Barrio y el Usuario.

              Siempre en el respeto de la legislación vigente, este Sitio Web de CityTasks - Servicios de Barrio se
              dirige a todas las personas, sin importar su edad, que puedan acceder y/o navegar por las páginas del
              Sitio Web.

              El Sitio Web está dirigido principalmente a Usuarios residentes en España. CityTasks - Servicios de Barrio
              no asegura que el Sitio Web cumpla con legislaciones de otros países, ya sea total o parcialmente. Si el
              Usuario reside o tiene su domiciliado en otro lugar y decide acceder y/o navegar en el Sitio Web lo hará
              bajo su propia responsabilidad, deberá asegurarse de que tal acceso y navegación cumple con la legislación
              local que le es aplicable, no asumiendo CityTasks - Servicios de Barrio responsabilidad alguna que se
              pueda derivar de dicho acceso.</p>

            <h4>III. ACCESO Y NAVEGACIÓN EN EL SITIO WEB: EXCLUSIÓN DE GARANTÍAS Y RESPONSABILIDAD</h4>
            <p>CityTasks - Servicios de Barrio no garantiza la continuidad, disponibilidad y utilidad del Sitio Web, ni
              de los Contenidos o Servicios. CityTasks - Servicios de Barrio hará todo lo posible por el buen
              funcionamiento del Sitio Web, sin embargo, no se responsabiliza ni garantiza que el acceso a este Sitio
              Web no vaya a ser ininterrumpido o que esté libre de error.

              Tampoco se responsabiliza o garantiza que el contenido o software al que pueda accederse a través de este
              Sitio Web, esté libre de error o cause un daño al sistema informático (software y hardware) del Usuario.
              En ningún caso CityTasks - Servicios de Barrio será responsable por las pérdidas, daños o perjuicios de
              cualquier tipo que surjan por el acceso, navegación y el uso del Sitio Web, incluyéndose, pero no
              limitándose, a los ocasionados a los sistemas informáticos o los provocados por la introducción de virus.

              CityTasks - Servicios de Barrio tampoco se hace responsable de los daños que pudiesen ocasionarse a los
              usuarios por un uso inadecuado de este Sitio Web. En particular, no se hace responsable en modo alguno de
              las caídas, interrupciones, falta o defecto de las telecomunicaciones que pudieran ocurrir.</p>
            <h4>IV. POLÍTICA DE ENLACES</h4>
            <p>Se informa que el Sitio Web de CityTasks - Servicios de Barrio pone o puede poner a disposición de los
              Usuarios medios de enlace (como, entre otros, links, banners, botones), directorios y motores de búsqueda
              que permiten a los Usuarios acceder a sitios web pertenecientes y/o gestionados por terceros.

              La instalación de estos enlaces, directorios y motores de búsqueda en el Sitio Web tiene por objeto
              facilitar a los Usuarios la búsqueda de y acceso a la información disponible en Internet, sin que pueda
              considerarse una sugerencia, recomendación o invitación para la visita de los mismos.

              CityTasks - Servicios de Barrio no ofrece ni comercializa por sí ni por medio de terceros los productos
              y/o servicios disponibles en dichos sitios enlazados.

              Asimismo, tampoco garantizará la disponibilidad técnica, exactitud, veracidad, validez o legalidad de
              sitios ajenos a su propiedad a los que se pueda acceder por medio de los enlaces.

              CityTasks - Servicios de Barrio en ningún caso revisará o controlará el contenido de otros sitios web, así
              como tampoco aprueba, examina ni hace propios los productos y servicios, contenidos, archivos y cualquier
              otro material existente en los referidos sitios enlazados.

              CityTasks - Servicios de Barrio no asume ninguna responsabilidad por los daños y perjuicios que pudieran
              producirse por el acceso, uso, calidad o licitud de los contenidos, comunicaciones, opiniones, productos y
              servicios de los sitios web no gestionados por CityTasks - Servicios de Barrio y que sean enlazados en
              este Sitio Web.

              El Usuario o tercero que realice un hipervínculo desde una página web de otro, distinto, sitio web al
              Sitio Web de CityTasks - Servicios de Barrio deberá saber que:

              No se permite la reproducción —total o parcialmente— de ninguno de los Contenidos y/o Servicios del Sitio
              Web sin autorización expresa de CityTasks - Servicios de Barrio.

              No se permite tampoco ninguna manifestación falsa, inexacta o incorrecta sobre el Sitio Web de CityTasks -
              Servicios de Barrio, ni sobre los Contenidos y/o Servicios del mismo.

              A excepción del hipervínculo, el sitio web en el que se establezca dicho hiperenlace no contendrá ningún
              elemento, de este Sitio Web, protegido como propiedad intelectual por el ordenamiento jurídico español,
              salvo autorización expresa de CityTasks - Servicios de Barrio.

              El establecimiento del hipervínculo no implicará la existencia de relaciones entre CityTasks - Servicios
              de Barrio y el titular del sitio web desde el cual se realice, ni el conocimiento y aceptación de
              CityTasks - Servicios de Barrio de los contenidos, servicios y/o actividades ofrecidas en dicho sitio web,
              y viceversa.</p>
            <h4>V. PROPIEDAD INTELECTUAL E INDUSTRIAL</h4>
            <p>CityTasks - Servicios de Barrio por sí o como parte cesionaria, es titular de todos los derechos de
              propiedad intelectual e industrial del Sitio Web, así como de los elementos contenidos en el mismo (a
              título enunciativo y no exhaustivo, imágenes, sonido, audio, vídeo, software o textos, marcas o logotipos,
              combinaciones de colores, estructura y diseño, selección de materiales usados, programas de ordenador
              necesarios para su funcionamiento, acceso y uso, etc.). Serán, por consiguiente, obras protegidas como
              propiedad intelectual por el ordenamiento jurídico español, siéndoles aplicables tanto la normativa
              española y comunitaria en este campo, como los tratados internacionales relativos a la materia y suscritos
              por España.

              Todos los derechos reservados. En virtud de lo dispuesto en la Ley de Propiedad Intelectual, quedan
              expresamente prohibidas la reproducción, la distribución y la comunicación pública, incluida su modalidad
              de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines
              comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización de CityTasks -
              Servicios de Barrio.

              El Usuario se compromete a respetar los derechos de propiedad intelectual e industrial de CityTasks -
              Servicios de Barrio. Podrá visualizar los elementos del Sitio Web o incluso imprimirlos, copiarlos y
              almacenarlos en el disco duro de su ordenador o en cualquier otro soporte físico siempre y cuando sea,
              exclusivamente, para su uso personal. El Usuario, sin embargo, no podrá suprimir, alterar, o manipular
              cualquier dispositivo de protección o sistema de seguridad que estuviera instalado en el Sitio Web.

              En caso de que el Usuario o tercero considere que cualquiera de los Contenidos del Sitio Web suponga una
              violación de los derechos de protección de la propiedad intelectual, deberá comunicarlo inmediatamente a
              CityTasks - Servicios de Barrio a través de los datos de contacto del apartado de INFORMACIÓN GENERAL de
              este Aviso Legal y Condiciones Generales de Uso.</p>
            <h4>VI. ACCIONES LEGALES, LEGISLACIÓN APLICABLE Y JURISDICCIÓN</h4>
            <p>CityTasks - Servicios de Barrio se reserva la facultad de presentar las acciones civiles o penales que
              considere necesarias por la utilización indebida del Sitio Web y Contenidos, o por el incumplimiento de
              las presentes Condiciones.

              La relación entre el Usuario y CityTasks - Servicios de Barrio se regirá por la normativa vigente y de
              aplicación en el territorio español. De surgir cualquier controversia en relación con la interpretación
              y/o a la aplicación de estas Condiciones las partes someterán sus conflictos a la jurisdicción ordinaria
              sometiéndose a los jueces y tribunales que correspondan conforme a derecho.

              Este documento de Aviso Legal y Condiciones Generales de uso del sitio web ha sido creado mediante el
              generador de plantilla de aviso legal y condiciones de uso online el día 01/06/2024.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->
  <footer class="bg-dark pt-6">
    <div class="section bg-dark text-light py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <h4 class="text-light">CityTasks</h4>
            <ul class="list-unstyled">
              <li><a href="whoweare.php" class="text-white-50 small" title="¿Quiénes somos?">¿Quiénes somos?</a></li>
              <li><a href="instructions.php" class="text-white-50 small" title="Cómo funciona">Cómo funciona</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h4 class="text-light">Soporte</h4>
            <ul class="list-unstyled">
              <li><a href="support.php" class="text-white-50 small" title="Centro de ayuda">Centro de ayuda</a></li>
              <li><a href="user-rules.php" class="text-white-50 small" title="Normas de uso">Normas de uso</a></li>
              <li><a href="tips.php" class="text-white-50 small" title="Consejos">Consejos</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h4 class="text-light">Legal</h4>
            <ul class="list-unstyled">
              <li><a href="legal-terms.php" class="text-white-50 small" title="Aviso legal">Aviso legal</a></li>
              <li><a href="use-conditions.php" class="text-white-50 small" title="Condiciones de uso">Condiciones de
                  uso</a></li>
              <li><a href="privacy-policy.php" class="text-white-50 small" title="Política de privacidad">Política de
                  privacidad</a></li>
              <li><a href="cookies-policy.php" class="text-white-50 small" title="Política de Cookies">Política de
                  Cookies</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="border-top text-center border-dark py-5">
      <p class="mb-0 text-light">Copyright &copy;
        <script>
          var CurrentYear = new Date().getFullYear()
          document.write(CurrentYear)
        </script> Diseñado &amp; Desarrollado <a class="text-white-50" href="Themefisher">Sergio Pulido Salvador</a>
      </p>
    </div>
  </footer>
  <!-- /footer -->

  <!-- jQuery -->
  <script src="../plugins/jQuery/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="../plugins/bootstrap/bootstrap.min.js"></script>
  <!-- slick slider -->
  <script src="../plugins/slick/slick.min.js"></script>
  <!-- filter -->
  <script src="plugins/shuffle/shuffle.min.js"></script>

  <!-- Main Script -->
  <script src="../js/script.js"></script>

</body>

</html>