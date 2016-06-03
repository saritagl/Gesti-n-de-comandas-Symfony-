## ¿Qué es Gestión de comandas (Symfony)?

Es un proyecto académico pertenciente a la materia electiva "Frameworks Web",
consiste en el desarrollo de una aplicación web mediante el uso de Symfony.

Esta aplicación es una versión sencilla de una aplicación web de gestión de
comandas de un restaurante.

El sistema deberá permitir administrar a los usuarios  del sistema,
administración de mesas, menú, precio de comidas y bebidas, facturación y
estadísticas del restaurante.

### Análisis de la situación

Se desea automatizar el sistema de cobro de un  pequeño restaurant.
Actualmente, todo el proceso de toma de pedidos de las mesas se realiza en forma
manual, lo que complica el cálculo de los ingresos al final del día.

El restaurant tiene un grupo de meseros que toman los pedidos de las mesas. A
veces, los clientes van solicitando comidas o bebidas adicionales a lo largo de
la cena, estos costos se van agregando a la cuenta de la mesa.
Los meseros desean poder consultar cuanto se ha consumido en cada mesa para
poder realizar el cobro al cliente.

Cuando un cliente paga, el mesero debe poder “cerrar” la cuenta y así la cuenta
de la mesa comienza nuevamente desde cero. Al final del día, el administrador
desea poder ver cuánto dinero ha ingresado por cada mesa, y así corroborar su
teoría que las mesas más cercanas a la ventana generan mayores ingresos.

También desea saber el total del dinero que se ha generado en el día. Además
desea saber cuáles son los meseros que trabajan más (atienden más mesas).
Por regla general, cuando un mesero comienza a atender a un cliente, él se
encarga de registrar todos los pedidos, hasta que le cobra al cliente.

El sistema debe entregar la cantidad de mesas que cada mesero ha atendido.

### Requesitos no funcionales

* Arquitectura
    * El sitio web de la aplicación deberá poderse explotar y administrar empleando
    cualquier navegador web.
    * Los datos de la aplicación deberán estar almacenados en un sistema gestor de
    bases de datos, sobre el cual puedan realizarse futuras consultas no previstas
    en la actualidad.

* Seguridad
    * Los datos de la aplicación solo podrán ser modificados por aquellas personas
    autorizadas para ello.

* Estándares
    * La licencia de uso del software donde se aloje y con el que se realice la
    aplicación debe ser lo menos restrictiva posible, preferentemente software
    de código abierto.
    * La aplicación deberá cumplir con los estándares marcados por el WWW
    Consortium (HTML 4.0 o superior, CSS 2.0, etc.)
    * El sitio web deberá cumplir con las normas de accesibilidad para aplicaciones
    web (WAI 2.0) definidas por el WWW Consortium, debiendo cumplir como mínimo
    el nivel A.
  
* Interfaz de usuario
    * El sitio web deberá tener una estructura clara, ordenando el contenido y
    las funciones de la aplicación en pestañas o apartados que abarquen todas
    las funcionalidades disponibles, según el perfil de seguridad del usuario
    conectado.
    * El sitio web deberá posibilitar la visualización de cualquier tipo de
    contenido multimedia (texto, gráficos, vídeos, etc.) en consonancia con la
    imagen corporativa de la empresa de gestión hotelera.
    * En los formularios de entrada, se valorará la inclusión de elementos de
    interacción asíncrona en la interfaz del cliente que mejoren la usabilidad
    de la aplicación.
