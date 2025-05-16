<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* login/index.html.twig */
class __TwigTemplate_ad897ca57591f82f1fd3ad92e17cefb9 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "login/index.html.twig"));

        // line 1
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        // line 2
        yield "
";
        // line 3
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 1
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Connexion";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 4
        yield "
  <div class=\"container\">
    <section>
      <h1 class=\"display-4\">Connexion</h1>
      <article>
        <form>
          <div class=\"form-group\">
            <label for=\"exampleInputEmail1\">Adresse e-mail</label>
            <input type=\"email\" class=\"form-control\" id=\"exampleInputEmail1\" aria-describedby=\"emailHelp\" placeholder=\"Entrer votre e-mail\"> <br>
            <small id=\"emailHelp\" class=\"form-text text-muted\">Nous ne partagerons jamais votre e-mail avec qui que ce soit.</small>
          </div>
          <div class=\"form-group\">
            <label for=\"exampleInputPassword1\">Mot de passe</label>
            <input type=\"password\" class=\"form-control\" id=\"exampleInputPassword1\" placeholder=\"Mot de passe\">
          </div>
          <button type=\"submit\" class=\"btn btn-primary\">Envoyer</button>
        </form>
      </article>
    </section>
  </div>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "login/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  87 => 4,  77 => 3,  60 => 1,  52 => 3,  49 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% block title %}Connexion{% endblock %}

{% block body %}

  <div class=\"container\">
    <section>
      <h1 class=\"display-4\">Connexion</h1>
      <article>
        <form>
          <div class=\"form-group\">
            <label for=\"exampleInputEmail1\">Adresse e-mail</label>
            <input type=\"email\" class=\"form-control\" id=\"exampleInputEmail1\" aria-describedby=\"emailHelp\" placeholder=\"Entrer votre e-mail\"> <br>
            <small id=\"emailHelp\" class=\"form-text text-muted\">Nous ne partagerons jamais votre e-mail avec qui que ce soit.</small>
          </div>
          <div class=\"form-group\">
            <label for=\"exampleInputPassword1\">Mot de passe</label>
            <input type=\"password\" class=\"form-control\" id=\"exampleInputPassword1\" placeholder=\"Mot de passe\">
          </div>
          <button type=\"submit\" class=\"btn btn-primary\">Envoyer</button>
        </form>
      </article>
    </section>
  </div>
{% endblock %}
", "login/index.html.twig", "/Users/iziben/Documents/École/Backend_PHP/Workspace/tp_symfony/templates/login/index.html.twig");
    }
}
