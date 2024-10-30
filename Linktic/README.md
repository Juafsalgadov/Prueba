Descripción
Este sistema de reservas ha sido diseñado para gestionar todo tipo de reservas, y en este caso específico, se utiliza para restaurantes.
Existen dos tipos de usuarios en el sistema: el administrador y el cliente. Ambos pueden realizar reservas, pero el administrador debe seleccionar al cliente de una lista al momento de hacer la reserva.
Al acceder al sistema, el administrador cuenta con un menú que le permite gestionar usuarios, servicios y reservas. También tiene la opción de "Ejecutar" una reserva cuando el cliente llega al establecimiento.
Por otro lado, el cliente puede ver sus reservas pendientes en forma de tarjetas y tiene la capacidad de cancelar cualquier reserva que desee.
Arquitectura del sistema
Backend
  Tecnologías:
     PHP 8.0: Se desarrolló un API RESTful desde cero con PHP puro.
     MySQL (MariaDB)
  Interacciones: Recibe solicitudes del frontend, procesa la lógica de negocio y se comunica con la base de datos para almacenar o recuperar información.

Documentación API
  Se generó utilizando PostMan
Ejecuccion 
 Para correr el sistema solo se necesita tener instalado un servidor web con PHP y MySQL.
 Es importante tener configurado el servidor para permitir redirecciones desde el archivo .htaccess
 El acceso a l base de dato se configura en el archi pdo.php quee está dentro del backend
 En el directorio principal del repositorio etá un archivo .sql para crear la base de datos
 


